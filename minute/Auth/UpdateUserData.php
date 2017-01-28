<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 7/6/2016
 * Time: 6:03 PM
 */
namespace Minute\Auth {

    use App\Model\MUserDatum;
    use Minute\Database\Database;
    use Minute\Error\UserUpdateDataError;
    use Minute\Event\Dispatcher;
    use Minute\Event\UserUpdateDataEvent;
    use Minute\Resolver\Resolver;
    use Minute\Session\Session;

    class UpdateUserData {
        /**
         * @var Dispatcher
         */
        private $dispatcher;
        /**
         * @var Session
         */
        private $session;
        /**
         * @var Database
         */
        private $database;
        /**
         * @var Resolver
         */
        private $resolver;

        /**
         * LoginHandler constructor.
         *
         * @param Dispatcher $dispatcher
         * @param Session $session
         * @param Database $database
         * @param Resolver $resolver
         */
        public function __construct(Dispatcher $dispatcher, Session $session, Database $database, Resolver $resolver) {
            $this->dispatcher = $dispatcher;
            $this->session    = $session;
            $this->database   = $database;
            $this->resolver   = $resolver;
        }

        public function update(UserUpdateDataEvent $event) {
            if ($user = $event->getUser()) {
                $fields        = array_diff($this->database->getColumns($user->getTable()), ['user_id', 'ident', 'created_at', 'updated_at']);
                $userDataModel = $this->resolver->getModel('UserData', true);

                foreach ($event->getNewData() as $key => $value) {
                    if (in_array($key, $fields)) {
                        if ($event->isOverwrite() || empty($user->$key) || (($key === 'verified') && ($value === 'true'))) {
                            $dataChanged = $dataChanged ?? ($user->$key !== $value);
                            $user->$key  = $key === 'password' ? password_hash($value, PASSWORD_DEFAULT) : $value;
                        }
                    } elseif (!empty($userDataModel)) {
                        /** @var MUserDatum $extra */
                        $extra = $userDataModel::firstOrCreate(['user_id' => $user->user_id, 'key' => $key]);

                        if ($event->isOverwrite() || empty($extra->data)) {
                            if (!empty($value)) {
                                $extra->data = $value;
                                $extra->save();
                            } else {
                                $extra->delete();
                            }
                        }
                    } else {
                        $event->setError('INVALID_FIELD');
                        throw new UserUpdateDataError("Field $key not found in users table");
                    }
                }

                if (!empty($dataChanged)) {
                    if ($user->save()) {
                        $event->setHandled(true);
                    }
                } else {
                    $event->setHandled(true);
                }
            } else {
                $event->setError('INVALID_USER');
            }
        }
    }
}
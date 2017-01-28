<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 7/6/2016
 * Time: 5:57 PM
 */
namespace Minute\Event {

    use App\Model\User;

    class UserUpdateDataEvent extends UserEventHandler {
        const USER_UPDATE_DATA = "user.update.data";

        /**
         * @var array
         */
        private $newData;
        /**
         * @var bool
         */
        private $overwrite;

        /**
         * UserLoginEvent constructor.
         *
         * @param User $user
         * @param array $newData
         * @param bool $overwrite
         */
        public function __construct(User $user, array $newData, bool $overwrite = true) {
            parent::__construct();

            $this->setUser($user);
            $this->setNewData($newData);
            $this->overwrite = $overwrite;
        }

        /**
         * @return boolean
         */
        public function isOverwrite(): bool {
            return $this->overwrite;
        }

        /**
         * @param boolean $overwrite
         *
         * @return UserUpdateDataEvent
         */
        public function setOverwrite(bool $overwrite): UserUpdateDataEvent {
            $this->overwrite = $overwrite;

            return $this;
        }

        /**
         * @return array
         */
        public function getNewData(): array {
            return $this->newData;
        }

        /**
         * @param array $newData
         *
         * @return UserUpdateDataEvent
         */
        public function setNewData(array $newData): UserUpdateDataEvent {
            $this->newData = $newData;

            return $this;
        }
    }
}
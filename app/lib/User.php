<?php

class User
{
    const LOGIN_EXPIRATION_TIME = 600;

    /**
     * @var int
     */
    private $id;

    /**
     * User constructor
     *
     * @param int $id
     * @throws \InvalidArgumentException
     */
    public function __construct($id)
    {
        if (self::isValid($id) == false) {
            throw new \InvalidArgumentException('Invalid ID passed');
        }

        $this->id = $id;
    }

    /**
     * Get current user ID
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Check whether user ID is valid
     *
     * @param int $id
     * @return bool
     */
    public static function isValid($id)
    {
        if (is_numeric($id) == false || $id < 1) {
            return false;
        }

        $db = DataBase::getInstance();

        $userId = $db->getOne('SELECT id FROM user WHERE id = ?', [$id]);

        if ($userId === false) {
            return false;
        }

        return true;
    }

    /**
     * Return object data as an array
     *
     * @return array
     */
    public function toArray()
    {
        $db = DataBase::getInstance();

        return $db->getRow('SELECT * FROM user WHERE id = ?', [$this->id]);
    }

    /**
     * Creates new user
     *
     * @param array $params
     * @throws \InvalidArgumentException
     * @return User
     */
    public static function insert(array $params)
    {
        $fields = ['username', 'password', 'name'];

        foreach ($params as $field => $value) {
            if (in_array($field, $fields, true) == false) {
                throw new \InvalidArgumentException('Invalid field "' . $field . '" passed');
            }
        }

        foreach ($fields as $field) {
            if (array_key_exists($field, $params) == false) {
                throw new \InvalidArgumentException('Missing required field "' . $field . '"');
            }
        }

        if (self::isFreeUsername($params['username']) == false) {
            throw new \InvalidArgumentException('Passed username is already taken');
        }

        // depending of the project architecture parameters validation can be called here

        $db = DataBase::getInstance();

        $params['password'] = self::hashPassword($params['password']);
        $params['created_at'] = date('Y-m-d H:i:s');

        $userId = $db->insert('user', $params);

        return new self($userId);
    }

    /**
     * Update user data
     *
     * @param array $params
     * @throws \InvalidArgumentException
     * @return void
     */
    public function update(array $params)
    {
        $allowedFields = ['username', 'password', 'name', 'last_online'];

        foreach ($params as $field => $value) {
            if (in_array($field, $allowedFields, true) == false) {
                throw new \InvalidArgumentException('Invalid field "' . $field . '" passed');
            }
        }

        if (isset($params['username']) && self::isFreeUsername($params['username'], $this->id) == false) {
            throw new \InvalidArgumentException('Passed username is already taken');
        }

        // depending of the project architecture parameters validation can be called here

        $db = DataBase::getInstance();

        if (isset($params['password'])) {
            $params['password'] = self::hashPassword($params['password']);
        }

        $db->update('user', ['id' => $this->id], $params);
    }

    /**
     * Delete current user
     *
     * @return void
     */
    public function delete()
    {
        $db = DataBase::getInstance();

        $db->delete('user', ['id' => $this->id]);
    }

    /**
     * Get all users
     *
     * @return array
     */
    public static function getAll()
    {
        $db = DataBase::getInstance();

        return $db->getAll('SELECT * FROM user ORDER BY id');
    }

    /**
     * Get user instance by username
     *
     * @param string $username
     * @throws \InvalidArgumentException
     * @return User|null
     */
    public static function findByUsername($username)
    {
        if (empty($username) || is_string($username) == false) {
            throw new \InvalidArgumentException('Invalid or empty username passed');
        }

        $db = DataBase::getInstance();
        $userId = $db->getOne('SELECT id FROM user WHERE username = ?', [$username]);

        if ($userId === false) {
            return null;
        }

        return new self($userId);
    }

    /**
     * Login user
     *
     * @param string $username
     * @param string $password
     * @throws \InvalidArgumentException
     * @return User|false
     */
    public static function login($username, $password)
    {
        if (empty($password) || is_string($password) == false) {
            throw new \InvalidArgumentException('Invalid or empty password passed');
        }

        $user = self::findByUsername($username);
        $userData = $user->toArray();

        if (password_verify($password, $userData['password'])) {
            $user->update(['last_online' => date('Y-m-d H:i:s')]);

            return $user;
        }

        return false;
    }

    /**
     * Check user authentication
     *
     * @return bool
     */
    public function checkAuthentication()
    {
        $userData = $this->toArray();

        if (strtotime($userData['last_online']) + self::LOGIN_EXPIRATION_TIME  < time()) {
            return false;
        }

        $this->update(['last_online' => date('Y-m-d H:i:s')]);

        return true;
    }

    /**
     * Validate post
     *
     * @param array $params
     * @return array
     */
    public static function validate(array $params)
    {
        $result = [
            'values' => $params,
            'errors' => [],
        ];

        /**
         * Some simple validations
         */

        if (array_key_exists('username', $params)) {
            if (is_string($params['username']) == false) {
                $result['values']['username'] = '';
                $result['errors']['username'] = 'Invalid username';
            } elseif (trim($params['username']) === '') {
                $result['values']['username'] = '';
                $result['errors']['username'] = 'Empty username';
            } elseif (mb_strlen($params['username']) < 4) {
                $result['errors']['username'] = 'Username length must be at least 4 characters';
            } elseif (mb_strlen($params['username']) > 20) {
                $result['errors']['username'] = 'Username length cannot be more than 20 characters';
            } elseif (preg_match('/^[a-zA-Z0-9_-]+$/', $params['username']) == false) {
                $result['errors']['username'] = 'There is not allowed character';
            }

            // if there are no username errors - check whether username is not already used
            if (isset($result['errors']['username']) == false) {
                $userId = null;
                if (isset($params['userId'])) {
                    $userId = $params['userId'];
                }

                if (self::isFreeUsername($params['username'], $userId) == false) {
                    $result['errors']['username'] = 'Username is already taken';
                }
            }
        }

        if (array_key_exists('password', $params)) {
            if (is_string($params['password']) == false) {
                $result['values']['password'] = '';
                $result['errors']['password'] = 'Invalid password';
            } elseif (trim($params['password']) === '') {
                $result['values']['password'] = '';
                $result['errors']['password'] = 'Empty password';
            } elseif (mb_strlen($params['password']) < 4) {
                $result['errors']['password'] = 'Password length must be at least 4 characters';
            } elseif (mb_strlen($params['password']) > 20) {
                $result['errors']['password'] = 'Password length cannot be more than 20 characters';
            } elseif (preg_match('/^[^\s]+$/', $params['password']) == false) {
                $result['errors']['password'] = 'There is a space in the password';
            }

            if (isset($result['errors']['password']) == false && array_key_exists('password2', $params)) {
                if ($params['password'] !== $params['password2']) {
                    $result['values']['password2'] = $params['password2'];
                    $result['errors']['password2'] = 'Confirm password does not match';
                }
            }
        }

        if (array_key_exists('name', $params)) {
            if (is_string($params['name']) == false) {
                $result['values']['name'] = '';
                $result['errors']['name'] = 'Invalid name';
            } elseif (trim($params['name']) === '') {
                $result['values']['name'] = '';
                $result['errors']['name'] = 'Empty name';
            } elseif (mb_strlen($params['name']) < 4) {
                $result['errors']['name'] = 'Name length must be at least 4 characters';
            } elseif (mb_strlen($params['name']) > 100) {
                $result['errors']['name'] = 'Name length cannot be more than 100 characters';
            }
        }

        return $result;
    }

    /**
     * Checks whether passed username is free
     *
     * @param string $username
     * @param null|int $id
     * @return bool
     */
    private static function isFreeUsername($username, $id = null)
    {
        $sql = 'SELECT COUNT(*) FROM user WHERE username = ?';
        $params = [$username];

        if ($id !== null) {
            $sql .= ' AND id != ?';
            $params[] = $id;
        }

        $db = DataBase::getInstance();

        if ($db->getOne($sql, $params) > 0) {
            return false;
        }

        return true;
    }

    /**
     * Hash user password
     *
     * @param string $password
     * @return string
     */
    private static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 8]);
    }
}
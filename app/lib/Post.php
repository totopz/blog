<?php

class Post
{
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

        $userId = $db->getOne('SELECT id FROM post WHERE id = ?', [$id]);

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

        return $db->getRow('SELECT * FROM post WHERE id = ?', [$this->id]);
    }

    /**
     * Creates new post
     *
     * @param array $params
     * @throws \InvalidArgumentException
     * @return Post
     */
    public static function insert(array $params)
    {
        $fields = ['user_id', 'title', 'text'];

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

        // depending of the project architecture parameters validation can be called here

        $db = DataBase::getInstance();

        $params['created_at'] = date('Y-m-d H:i:s');

        $postId = $db->insert('post', $params);

        return new self($postId);
    }

    /**
     * Update post data
     *
     * @param array $params
     * @throws \InvalidArgumentException
     * @return void
     */
    public function update(array $params)
    {
        $allowedFields = ['title', 'text'];

        foreach ($params as $field => $value) {
            if (in_array($field, $allowedFields, true) == false) {
                throw new \InvalidArgumentException('Invalid field "' . $field . '" passed');
            }
        }

        // depending of the project architecture parameters validation can be called here

        $db = DataBase::getInstance();

        $db->update('post', ['id' => $this->id], $params);
    }

    /**
     * Delete current post
     *
     * @return void
     */
    public function delete()
    {
        $db = DataBase::getInstance();

        $db->delete('post', ['id' => $this->id]);
    }

    /**
     * Get all posts
     *
     * @param null $userId
     * @throws \InvalidArgumentException
     * @return array
     */
    public static function getAll($userId = null)
    {
        if ($userId !== null && User::isValid($userId) == false) {
            throw new \InvalidArgumentException('Invalid user ID passed');
        }

        $db = DataBase::getInstance();

        $sql = 'SELECT * FROM post';
        $params = [];

        if ($userId !== null) {
            $sql .= ' WHERE user_id = ?';
            $params[] = $userId;
        }

        $sql .= ' ORDER BY id';

        return $db->getAll($sql, $params);
    }

    /**
     * Get post for homepage
     *
     * @param $page
     * @param $postsPerPage
     * @throws \InvalidArgumentException
     * @return array
     */
    public static function getPosts($page, $postsPerPage)
    {
        if (is_numeric($page) == false || $page < 1) {
            throw new \InvalidArgumentException('Invalid page passed');
        }

        if (is_numeric($postsPerPage) == false || $postsPerPage < 1) {
            throw new \InvalidArgumentException('Invalid page passed');
        }

        $db = DataBase::getInstance();

        $offset = ($page - 1) * $postsPerPage;
        $limit = $offset . ', ' . $postsPerPage;

        return $db->getAll('
            SELECT 
                p.*,
                u.name AS user_name
            FROM post AS p
            INNER JOIN user AS u ON u.id = p.user_id
            ORDER BY id DESC
            LIMIT ' . $limit . '
        ');
    }

    /**
     * Get posts count
     *
     * @return int
     */
    public static function getPostsCount()
    {
        $db = DataBase::getInstance();

        return $db->getOne('SELECT COUNT(*) FROM post');
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

        if (array_key_exists('title', $params)) {
            if (is_string($params['title']) == false) {
                $result['values']['title'] = '';
                $result['errors']['title'] = 'Invalid title value';
            } elseif (trim($params['title']) === '') {
                $result['values']['title'] = '';
                $result['errors']['title'] = 'Empty title';
            } elseif (mb_strlen($params['title']) < 4) {
                $result['errors']['title'] = 'Title length must be at least 4 characters';
            } elseif (mb_strlen($params['title']) > 255) {
                $result['errors']['title'] = 'Title length cannot be more than 255 characters';
            }
        }

        if (array_key_exists('text', $params)) {
            if (is_string($params['text']) == false) {
                $result['values']['text'] = '';
                $result['errors']['text'] = 'Invalid text value';
            } elseif (trim($params['title']) === '') {
                $result['values']['text'] = '';
                $result['errors']['text'] = 'Empty text';
            } elseif (mb_strlen($params['text']) < 4) {
                $result['errors']['text'] = 'Text length must be at least 4 characters';
            } elseif (mb_strlen($params['text']) > 65000) {
                $result['errors']['text'] = 'Text length cannot be more than 65000 characters';
            }
        }

        return $result;
    }
}
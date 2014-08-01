<?php

/**
 * Description of dbengine
 *
 * @author imerin
 */

class DbEngine
{
    //connection
    private $driver;
    private $type;
    private $host;
    private $port;    
    private $db_name;
    private $user;
    private $pass;
    private $encoding;

    //options
    private $persistent;

    //instance
    private $instance;  //http://php.net/manual/en/book.pdo.php (en los primeros comentarios hay un wrapper singleton)


    public function __construct($driver = '', $type = '', $host = '', $port = '',
                                $db_name = '', $user = '', $pass = '', $encoding = '',
                                $persistent = false)
    {
        //connection
        $this->setDriver($driver);
        $this->setType($type);
        $this->setHost($host);
        $this->setPort($port);
        $this->setEncoding($encoding);
        $this->setDbName($db_name);
        $this->setUser($user);
        $this->setPass($pass);

        //options
        $this->setPersistent($persistent);

        //instance
        $this->instantiateDriver();
    }


    public function getDriver()
    {
        return $this->driver;
    }


    public function getType()
    {
        return $this->type;
    }


    public function getHost()
    {
        return $this->host;
    }


    public function getPort()
    {
        return $this->port;
    }


    public function getDbName()
    {
        return $this->db_name;
    }


    public function getUser()
    {
        return $this->user;
    }


    public function getPass()
    {
        return $this->pass;
    }


    public function getEncoding()
    {
        return $this->encoding;
    }


    public function getPersistent()
    {
        return $this->persistent;
    }
    
    
    public function setDriver($name)
    {
        if (!is_string($name))
        {
            d::fp("driver name ($name) must be a string", 'ERROR(code)::', 'e');
            return false;
        }

        switch (strtolower($name))
        {
            case 'pdo':
                $this->driver = 'pdo';
                break;

            default:
                $this->driver = 'pdo';
                break;
        }
    }


    public function setType($db_type)
    {
        if (!is_string($db_type))
        {
            d::fp("database type ($db_type) must be a string", 'ERROR(code)::', 'e');
            return false;
        }

        switch (strtolower($db_type))
        {
            case 'mysql':
                $this->type = 'mysql';
                break;

            default:
                $this->type = 'mysql';
                break;
        }
    }


    public function setHost($host)
    {
        if (!is_string($host))
        {
            d::fp("host name ($host) must be a string", 'ERROR(code)::', 'e');
            return false;
        }

        $this->host = $host;
    }


    public function setPort($port)
    {
        if (!is_integer($port) || !($port > 0))
        {
            d::fp("port number ($port) must be a positive integer", 'ERROR(code)::', 'e');
            return false;
        }

        $this->port = $port;
    }


    public function setDbName($db_name)
    {
        if (!is_string($db_name))
        {
            d::fp("database name ($db_name) must be a string", 'ERROR(code)::', 'e');
            return false;
        }

        $this->db_name = $db_name;
    }


    public function setUser($user)
    {
        if (!is_string($user))
        {
            d::fp("user name ($user) must be a string", 'ERROR(code)::', 'e');
            return false;
        }

        $this->user = $user;
    }


    public function setPass($pass)
    {
        if (!is_string($pass))
        {
            d::fp("password ($pass) must be a string", 'ERROR(code)::', 'e');
            return false;
        }

        $this->pass = $pass;
    }


    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
    }


    public function setPersistent($persistent)
    {
        if (!is_bool($persistent))
        {
            d::fp("persistent ($persistent) must be a boolean value", 'ERROR(code)::', 'e');
            return false;
        }

        $this->persistent = $persistent;
    }


    private function instantiateDriver()
    {
        $DSN_string = $this->getDSNString();
        $options = $this->getOptionsArray();

        if (!$DSN_string || !isset($this->user) || $this->getUser() === '')
        {
            d::fp("DB Driver could not be instantiated (DSN: $DSN_string | user: $this->user)", 'ERROR(code)::', 'e');
            return false;
        }

        $this->instance = new PDO($DSN_string, $this->getUser(), $this->getPass(),
                                  $options);

        //@TODO : create instance with try catch block, throw exception depending on result
        /*
                try {
                    $dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass);
                } catch (PDOException $e) {
                    print "Error!: " . $e->getMessage() . "<br/>";
                    die();
                }
        */
    }

    
    private function getDSNString()
    {
        if (!is_string($this->getHost()) || !is_string($this->getDbName()))
        {
            d::fp("DSN params (host: $this->host | db_name: $this->db_name) are not set", 'ERROR(code)::', 'e');
            return false;
        }

        $string = "$this->type:host=$this->host;dbname=$this->db_name;";

        if (isset($this->encoding))
        {
            $string .= 'charset='.strtoupper($this->getEncoding());
        }

        return $string;
    }


    private function getOptionsArray()
    {
        $options = array();

        if ($this->getPersistent())
        {
            $options[PDO::ATTR_PERSISTENT] = $this->getPersistent();
        }

        return $options;
    }
    

    public function queryDb($sql, array $params = array(), $prepared = false,
                          $fetch_type = PDO::FETCH_ASSOC)
    {
        if ($prepared)
        {
            return $this->preparedStatement($sql, $params, $fetch_type);
        }
        else
        {
            return $this->plainQuery($sql, $params, $fetch_type);
        }
    }


        private function plainQuery($sql, array $params, $fetch_type)
        {
            $sanitized_sql = $this->parseQuery($sql, $params);

            if ($fetch_type === 0)
            {
                return $this->exec($sanitized_sql);
            }
            else
            {
                return $this->query($sanitized_sql, $fetch_type);
            }
        }


            private function parseQuery($sql, $params)
            {
                if (preg_match_all('/\%[nifds]/', $sql, $matches))
                {
                    for ($i=0; $i<count($matches[0]); $i++)
                    {
                        if (!$this->stringMatchPlaceholder($params[$i], $matches[0][$i]))
                        {
                            d::fp("Query param($params[$i]) does not match placeholder($matches[0][$i])", 'ERROR(code)::', 'e');
                            return false;
                        }

                        $sql = str_replace($matches[0][$i], $params[$i], $sql);
                    }
                }

                return $sql;
            }


            private function stringMatchPlaceholder($string, $placeholder)
            {
                switch ($placeholder)
                {
                    case '%n':
                        return Sanitize::isPostiveInteger($string);
                        break;

                    case '%i':
                        return is_int($string);
                        break;

                    case '%f':
                        return is_float($string);
                        break;

                    case '%d':
                        return Sanitize::isDateString($string) ||
                               Sanitize::isTimeString($string) ||
                               Sanitize::isDateTimeString($string);
                        break;

                    case '%s':
                        if (Sanitize::isInjectedString($string))
                        {
                            d::fp("String($string) may be SQL injected", 'ERROR(code)::', 'e');
                            return false;
                        }

                        return is_string($string);
                        break;

                    default:
                        d::fp("Placeholder($placeholder) does not match with any type", 'ERROR(code)::', 'e');
                        return false;
                }
            }


        private function preparedStatement($sql, array $params, $fetch_type)
        {
            $stmt = $this->instance->prepare($sql);
            $stmt->execute($params);

            return $this->getResult($stmt, $fetch_type);
        }


        //@TODO: 
        //private function multiplePreparedStatement($sql, array $params_array, $fetch_type);
        //  execute the same prepared statement several times with different params
        //  something like this:
        //                  $stmt = $this->instance->prepare($sql);
        //                  $stmt->execute($params[0]);
        //                  $stmt->execute($params[1]);
        //                  $stmt->execute($params[2]);


        private function getResult($stmt, $fetch_type = PDO::FETCH_ASSOC)
        {
            //types (0-12)::
            //  FETCH_LAZY, FETCH_ASSOC, FETCH_NUM, FETCH_BOTH, FETCH_OBJ,
            //  FETCH_BOUND, FETCH_COLUMN, FETCH_CLASS, FETCH_INTO, FETCH_FUNC
            //  FETCH_NAMED, FETCH_KEY_PAIR
            if ($fetch_type < PDO::FETCH_LAZY || $fetch_type > PDO::FETCH_KEY_PAIR)
            {
                $fetch_type = PDO::FETCH_ASSOC;
            }

            return $stmt->fetchAll($fetch_type);
        }


    public function transaction(array $sql_list, $get_results = false)
    {
        $results = array();
        try
        {
            $this->instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->beginTransaction();

            foreach ($sql_list as $sql)
            {
                if ($get_results)
                {
                    $this->exec($sql);
                }
                else
                {
                    $results[] = $this->query($sql);
                }
            }

            $this->commit();
        }
        catch (Exception $e)
        {
            $this->rollBack();

            d::fp($e->getMessage(), 'ERROR(code)::', 'e');
        }

        return $results;
    }


        public function beginTransaction()
        {
            $this->instance->beginTransaction();
        }


        public function commit()
        {
            $this->instance->commit();
        }


        public function exec($sql)
        {
            $this->instance->exec($sql);
        }


        public function query($sql, $fetch_type = PDO::FETCH_ASSOC)
        {
            $stmt = $this->instance->query($sql);

            return $this->getResult($stmt, $fetch_type);
        }


        public function rollBack()
        {
            $this->instance->rollBack();
        }

}

?>
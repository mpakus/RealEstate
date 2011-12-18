<?php
error_reporting( E_ALL );

date_default_timezone_get( 'Asia/Bangkok' );    // timezone (default: php.ini date.timezone)
mb_internal_encoding( 'UTF-8' );  // everythin in UTF-8
ini_set( 'default_charset', 'UTF-8' );

/**
 * Fixture class
 * 
 * @var $db database connection handler
 */
class Fixture{
    private $db = NULL;
    public function __construct(){}
    
    /**
     * Connect to database
     * 
     * @param type $dsn
     * @param type $user
     * @param type $psw
     * @throws Exception
     */
    public function connect( $dsn, $user, $psw='' ){
        $this->db = new PDO( $dsn, $user, $psw );
        // set UTF-8 as default charset
		$this->db->query('SET NAMES "utf8"');
		$this->db->query("SET sql_mode = default");
    }
    
    /**
     * Generate and insert new row
     * 
     * @param type $count count of rows
     */
    public function fill( $count=1 ){
        srand( time() );        
        for( $i=1; $i<=$count; $i++ ){
            $row = $this->generate();
            $id  = $this->insert( $row );
            $this->insert_photos( $id );
        }
    }
    
    /**----------------------- PRIVATE -----------------------------------------------**/
    
    /**
     * Generate randomly realestate object
     * 
     * @return array
     */
    private function generate(){
        $descriptions = array(
            'Хороший и уютный', 'Просто замечательный', 'Офигенный', 'Самый лучший',
            'Просторный и солнечный', 'Уютный и гостеприимный', 'Тихий и расслабляющий',
            'Безумно красивый', 'Яркий и солнечный', 'Просторный и очень теплый',
            'Мощный, просторный как колос', 'Рядом с морем, всего 100 метров',
            'Не жилье, а ', 'Свежий взгляд на ', 'Очень красивый ', 
            'Приятная во всех отношениях', 'Самая лучшая', 'Очень красивый'
        );
        $cities = 9;
        $stars  = 5;
        $rooms  = 4;
        $types  = array(
            array(1, 'Квартира'),
            array(2, 'Дом'),
            array(3, 'Гостиница'),
            array(4, 'Вилла'),
            array(5, 'Бунгало'),
            array(6, 'Гестхауз'),
        );
        //
        $row = array();
        // 0 or 1
        $row['bar']      = $this->oz();
        $row['pool']     = $this->oz();
        $row['bath']     = $this->oz();
        $row['shower']   = $this->oz();
        $row['cctv']     = $this->oz();
        $row['internet'] = $this->oz();
        $row['tv']       = $this->oz();
        $row['parking']  = $this->oz();
        // stars & rooms & city
        $row['stars']   = rand( 1, $stars );
        $row['rooms']   = rand( 1, $rooms );
        $row['city_id'] = rand( 1, $cities );        
        // type_id        
        $type_id         = $this->rand( $types );
        $type_id         = (int)$type_id[0];
        $row['type_id']  = $type_id;
        // title
        $row['title']    = (string)$this->rand( $descriptions ).' '.$types[$type_id-1][1];
        // description
        $row['description'] = '';
        for( $i=1; $i<=rand(1,5); $i++ )
            $row['description'] .= $this->rand( $descriptions ).".\n ";
        
        return $row;
    }
    
    /**
     * Return random item from the array
     * 
     * @param  type $array
     * @return mixed
     */
    private function rand( $array=NULL ){
        if( is_array($array) ) return $array[ rand(0, count($array)-1) ];        
    }
    
    /**
     * One or Zero
     * 
     * @return integer
     */
    private function oz(){
        return (int)rand(0, 1);
    }
    
    /**
     * Insert new row to ESTATES table
     * 
     * @param  array $row
     * @return integer 
     */
    private function insert( $row ){   
        echo '.';
        try{
            $q = $this->db->prepare(
                "INSERT INTO `estates`
                (
                    type_id, city_id, stars, rooms, bar, pool, bath, shower,
                    cctv, internet, tv, parking, title, description
                )
                VALUES
                (
                    :type_id, :city_id, :stars, :rooms, :bar, :pool, :bath, :shower,
                    :cctv, :internet, :tv, :parking, :title, :description
                )"
            );
            $r = $q->execute( array(
                ':type_id'     => $row['type_id'],
                ':city_id'     => $row['city_id'],
                ':stars'       => $row['stars'],
                ':rooms'       => $row['rooms'],
                ':bar'         => $row['bar'],
                ':pool'        => $row['pool'],
                ':bath'        => $row['bath'],
                ':shower'      => $row['shower'],
                ':cctv'        => $row['cctv'],
                ':internet'    => $row['internet'],
                ':tv'          => $row['tv'],
                ':parking'     => $row['parking'],
                ':title'       => $row['title'],
                ':description' => $row['description'],
            ) );
        }catch( PDOException $e ){
            throw new Exception( $e->getMessage() );
        }
        return $this->db->lastInsertId();
    }
    
    /**
     *
     * @param type $estate_id 
     */
    private function insert_photos( $estate_id ){
        $photos = array(
            '53b7613ee067bfa5449fed2d9878a7c4.jpg',
            '5f99fec140c8745a459eee6355237405.jpg',
            '6e0a745bba6e38367980bede62643134.jpg',
            '6e6c71ac668da880f49dc067b41d4412.jpg',
            '6f3bae652b905c5813e8effe3272306b.jpg',
            '8c344b1de425fda0be3b81eb2bd76dec.jpg',
            '915fcd747d62579d89d5b42d76fdf423.jpg',
            '9978c9a01174104a19fb097024c27ddf.jpg',
            'cbc4b2ae39fb3a02a3306a03a1ea901c.jpg',
            'db5aa20fcb9811345dad08d9ad204845.jpg',
        );
        
        $count = rand( 1, 8 );
        $q = $this->db->prepare(
            "INSERT INTO `photos`
            (
                estate_id, preview, photo
            )
            VALUES
            (
                :estate_id, :preview, :photo
            )"
        );
        for( $i=1; $i<=$count; $i++ ){
            try{
                $photo = $this->rand( $photos );
                $r = $q->execute( array(
                    ':estate_id'   => $estate_id,
                    ':preview'     => 'mini_'.$photo,
                    ':photo'       => $photo,
                ) );
            }catch( PDOException $e ){
                // @todo: dont scream be quite
                //throw new Exception( $e->getMessage() );
            }            
        }
    }
    
}

try{
    $fix = new Fixture();
    $fix->connect( 'mysql:host=localhost;dbname=state', 'root', '900' );
    $fix->fill( 2000000 );
    echo "\nOK.";
}catch( Exception $e ){
    die( $e->getMessage() );
}
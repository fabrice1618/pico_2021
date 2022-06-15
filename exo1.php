<?php 
define('QUERY_INSERT', "INSERT INTO geoip (ip_from, ip_to, country_code, country_name, region_name, city_name, latitude, longitude) VALUES (:ip_from, :ip_to, :country_code, :country_name, :region_name, :city_name, :latitude, :longitude) " );
define('GEOIP_FILE', 'geoip.csv');

define('DB_HOST',       'localhost');
define('DB_NAME',       'pico');
define('DB_CHARSET',    'utf8');
define('DB_USER',       'pico');
define('DB_PWD',        'ghjk');

/*
ip_from      | int unsigned | YES  |     | NULL    |       |
| ip_to        | int unsigned | NO   | PRI | NULL    |       |
| country_code | char(2)      | YES  |     | NULL    |       |
| country_name | varchar(64)  | YES  |     | NULL    |       |
| region_name  | varchar(128) | YES  |     | NULL    |       |
| city_name    | varchar(128) | YES  |     | NULL    |       |
| latitude     | double       | YES  |     | NULL    |       |
| longitude    | double       |
*/
$fields  = [
    ['fieldname'=>'ip_from',         'csv_num'=>0, 'type'=>PDO::PARAM_INT],
    ['fieldname'=>'ip_to',           'csv_num'=>1, 'type'=>PDO::PARAM_INT],
    ['fieldname'=>'country_code',    'csv_num'=>2, 'type'=>PDO::PARAM_STR],
    ['fieldname'=>'country_name',    'csv_num'=>3, 'type'=>PDO::PARAM_STR],
    ['fieldname'=>'region_name',     'csv_num'=>4, 'type'=>PDO::PARAM_STR],
    ['fieldname'=>'city_name',       'csv_num'=>5, 'type'=>PDO::PARAM_STR],
    ['fieldname'=>'latitude',        'csv_num'=>6, 'type'=>PDO::PARAM_STR],
    ['fieldname'=>'longitude',       'csv_num'=>7, 'type'=>PDO::PARAM_STR]
    ];


try {
    $dbh = new PDO( 
        'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET, 
        DB_USER, 
        DB_PWD,
        array(PDO::ATTR_PERSISTENT => true)
        );
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    dumpException($e);
    return(1);
}

$row = 1;
if (($fp = fopen(GEOIP_FILE, "r")) !== false) {
    while (($data = fgetcsv($fp, 1024, ",")) !== false) {
        insertGeoip( $data );
        if ($row % 100 == 0 ) 
            print("Ligne : $row\n");
        $row++;
    }
    fclose($fp);
}

print("Lignes importées: $row\n");
$dbh = null;    // Fermeture DB
return(0);


function insertGeoip( $data ) 
{
    global $dbh;
    global $fields;
    
    // Prepare SQL statement
    $stmt1 = $dbh->prepare( QUERY_INSERT );
    foreach ($fields as $field) {
        $stmt1->bindValue(
            ':'.$field['fieldname'], 
            $data[$field['csv_num']], 
            $field['type']
            );
    }
/*
    $stmt1->bindValue(':ip_from', $data[0], PDO::PARAM_INT);
    $stmt1->bindValue(':ip_to', $data[1], PDO::PARAM_INT);
    $stmt1->bindValue(':country_code', $data[2], PDO::PARAM_STR);
    $stmt1->bindValue(':country_name', $data[3], PDO::PARAM_STR);
    $stmt1->bindValue(':region_name', $data[4], PDO::PARAM_STR);
    $stmt1->bindValue(':city_name', $data[5], PDO::PARAM_STR);
    $stmt1->bindValue(':latitude', $data[6], PDO::PARAM_STR);
    $stmt1->bindValue(':longitude', $data[7], PDO::PARAM_STR);
    */
    if ( $stmt1->execute() ) {
        // Requete bien executee
    }

}


function dumpException($e)
{
    printf(
        "%s: dans %s à la ligne %d : %s",
        get_class($e),
        $e->getFile(),
        $e->getLine(),
        $e->getMessage()
        );

}
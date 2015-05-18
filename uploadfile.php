<?php

class BobDemo{
	const DB_HOST = 'localhost';
	const DB_NAME = 'blobdemo';
	const DB_USER = 'blobsite';
	const DB_PASSWORD = 'password';

	private $conn = null;

	/**
	 * Open the database connection
	 */
	public function __construct(){
		// open database connection
		$connectionString = sprintf("mysql:host=%s;dbname=%s;charset=utf8",
				BobDemo::DB_HOST,
				BobDemo::DB_NAME);

		try {
			$this->conn = new PDO($connectionString,
					BobDemo::DB_USER,
					BobDemo::DB_PASSWORD);
			//for prior PHP 5.3.6
			//$conn->exec("set names utf8");

		} catch (PDOException $pe) {
			die($pe->getMessage());
		}
	}



	/**
	 * insert blob into the files table
	 * @param string $filePath
	 * @param string $mime mimetype
	 */
	public function insertBlob($filePath,$mime){
		$blob = fopen($filePath,'rb');

		$sql = "INSERT INTO files(mime,data) VALUES(:mime,:data)";
		$stmt = $this->conn->prepare($sql);

		$stmt->bindParam(':mime',$mime);
		$stmt->bindParam(':data',$blob,PDO::PARAM_LOB);

		$stmt->execute();
                $id = $this->conn->lastInsertId();
                return $id;
                
	}

	/**
	 * update the files table with the new blob from the file specified
	 * by the filepath
	 * @param int $id
	 * @param string $filePath
	 * @param string $mime
	 * @return boolean
	 */
	function updateBlob($id,$filePath,$mime) {

		$blob = fopen($filePath,'rb');

		$sql = "UPDATE files
				SET mime = :mime,
				data = :data
				WHERE id = :id";

		$stmt = $this->conn->prepare($sql);

		$stmt->bindParam(':mime',$mime);
		$stmt->bindParam(':data',$blob,PDO::PARAM_LOB);
		$stmt->bindParam(':id',$id);

		return $stmt->execute();

	}

	/**
	 * select data from the the files
	 * @param int $id
	 * @return array contains mime type and BLOB data
	 */
	public function selectBlob($id) {

		$sql = "SELECT mime,
				data
				FROM files
				WHERE id = :id";

		$stmt = $this->conn->prepare($sql);
		$stmt->execute(array(":id" => $id));
		$stmt->bindColumn(1, $mime);
		$stmt->bindColumn(2, $data, PDO::PARAM_LOB);

		$stmt->fetch(PDO::FETCH_BOUND);

		return array("mime" => $mime,
				"data" => $data);

	}

	/**
	 * close the database connection
	 */
	public function __destruct() {
		// close the database connection
		$this->conn = null;
	}
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    //if (!array_key_exists('uploadedimage', $_FILES)) {
        $image = $_FILES['uploadedimage'];

        $info = getimagesize($image['tmp_name']);

        $blobObj = new BobDemo();

    $id = $blobObj->insertBlob($image['tmp_name'],$info["mime"]);
    
    
	 
	        // finally, redirect the user to view the new image
	        //header('Location: uploadfile.php?id=' . $id);
	        //exit;
    //}
}

?>
<HTML><BODY>
    
        <form method="post" action="uploadfile.php" enctype="multipart/form-data">
                <div>
                    <input type="file" name="uploadedimage" />
                    <input type="submit" value="Upload Image" />
                </div>
            </form>
        
    </BODY></HTML>
<?php


class User
{
	protected $conn;

	public function __construct($data = null)
	{
		$this->connect();
	}

	protected function connect()
	{
		try {
			$this->conn = new PDO('mysql:host=localhost;dbname=teacherbot', 'root', '');
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo 'DB error: ' . $e->getMessage();
			die();
		}
	}
	// 
	// ============================================================================
	// Performs an sql query.
	// @sql - any sql query, 
	// @bindings - assoc array parametrs for the WHERE clause,
	// @insert - is this an insert statement or not, if it is we dont need to fetch,
	// instead return the last insert id.
	// =============================================================================
	// 
	protected function query($sql, $bindings = false, $mood = false)
	{
		if ($bindings) {
			$stmt = $this->conn->prepare($sql);
			$stmt->execute($bindings);
			if ($mood == 'insert') return $this->conn->lastInsertId();
			elseif ($mood == 'update') return $stmt->rowCount();
			elseif ($mood == 'delete') return $stmt->rowCount();
		} else $stmt = $this->conn->query($sql);

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	//
	// =============================================================================
	// 					CREATE
	// Adds a user and returns its id.
	// add(['username' => 'lola', 'password' => '123', 'role' => 'user']) 
	// =============================================================================
	// 
	public function add($data)
	{
		foreach ($data as $key => $value) @$values .= ":$key, ";
		$values = preg_replace('/, $/', '', $values);
		$sql = "INSERT INTO users (username, password, role) VALUES ($values)";
		return $this->query($sql, $data, 'insert');
	}
	//
	// =============================================================================
	// 					READ
	// get() returns all the users in the table.
	// get(['id' => 5]) returns the user with the id 5.
	// get(['username' => 'ulugbek']) returns all the users whose usernames = ulugbek.
	// =============================================================================
	//
	public function get($data = false)
	{
		if ($data) {
			foreach ($data as $key => $value) $where = "$key = :$key";
			return $this->query("SELECT * FROM users WHERE $where", $data);
		} else return $this->query("SELECT * FROM users");
	}
	// 
	// =============================================================================
	// 					UPDATE
	// Update one user by id
	// @id - the user id that you want to update
	// @update - new data in an assoc array to update
	// update(12, ['username' => 'Ulugbek', 'password' => '101', 'role' => 'king']);
	// You dont have to update all the fileds, you just can update one or two.
	// =============================================================================
	// 
	public function update($id, $update)
	{
		$the_user = $this->get(['id' => $id])[0];

		foreach ($update as $key => $value) @$key_values .= "$key = :$key, ";
		$key_values = preg_replace('/, $/', '', $key_values);
		$sql = "UPDATE users SET $key_values WHERE id = " . $the_user['id'];

		return $this->query($sql, $update, 'update');
	}
	//
	// =============================================================================
	// 					DELETE
	// Delete one or any number of users by a given parametr
	// delete(['role' => 'user']) - deletes all the users whose role is user
	// delete(['id' => 2]) - deletes the user with the id of 2
	// =============================================================================
	// 
	public function delete($data)
	{
		foreach ($data as $key => $value) $where = "$key = :$key";
		return $this->query("DELETE FROM users WHERE $where", $data, 'delete');
	}
}

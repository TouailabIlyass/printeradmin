<?php

require_once('connection.php');


class AdminController{

	private static $con = null;

	//getting statistics about the orders
	public static function getStatistics()
	{
		try{
			if(self::$con == null)
				self::$con = ConnectionBD::getConnection();
			$data = [];
			
			//getting all new orders count
			$stmt = self::$con->prepare("SELECT count(*) as 'count' FROM orders where status is null");
			$stmt->execute();
			$data['new_orders_num'] = $stmt->fetch()['count'];

			//getting all orders count
			$stmt = self::$con->prepare("SELECT count(*) as 'count' FROM orders");
			$stmt->execute();
			$data['all_orders_num'] = $stmt->fetch()['count'];
			

			//getting all historic orders count
			$data['historic_orders_num'] = $data['all_orders_num'] - $data['new_orders_num'];


			//getting the number of orders per day
			$stmt = self::$con->prepare("select date, count(date) as 'count' from orders group by date ASC ");
			$stmt->execute();
			$data['orders_per_day'] = $stmt->fetchAll();

			//returning data dictionnary
			return $data;
		
		}catch(Exception $e)
		{
			return [];
		}
		return [];
	}


	public static function getNewOrders()
	{
		try{
			if(self::$con == null)
				self::$con = ConnectionBD::getConnection();
			$data = [];
			$stmt = self::$con->prepare("SELECT * FROM orders where status is null");
			$stmt->execute();
			$data['items'] = $stmt->fetchAll();
			
			return $data;
		
		}catch(Exception $e)
		{
			return [];
		}
		return [];
	}


	public static function getHistoricOrders()
	{
		try{
			if(self::$con == null)
				self::$con = ConnectionBD::getConnection();
			$data = [];
			$stmt = self::$con->prepare("SELECT * FROM orders where status is not null");
			$stmt->execute();
			$data['items'] = $stmt->fetchAll();
			
			return $data;
		
		}catch(Exception $e)
		{
			return [];
		}
		return [];
	}


	public static function setOrderApprouve($id)
	{
		try{
			if(self::$con == null)
				self::$con = ConnectionBD::getConnection();
			$stmt = self::$con->prepare("update orders set status = 1 where id = ?");
			$stmt->execute([$id]);
			return true;
		}catch(Exception $e)
		{
			return false;
		}
		return false;
	}


	public static function addOrder($arr)
	{
		try{
			if(self::$con == null)
				self::$con = ConnectionBD::getConnection();
			$stmt = self::$con->prepare("insert into orders(firstname, lastname, email, postal_code, width, height, address, phone, file_name) values (:firstname, :lastname, :email, :postal_code, :width, :height, :address, :phone, :file_name)");
			$stmt->execute($arr);
			return true;
		}catch(Exception $e)
		{
			return false;
		}
		return false;
	}

	public static function login($post)
	{
		try{
			if(self::$con == null)
				self::$con = ConnectionBD::getConnection();
			$stmt = self::$con->prepare("select * from users where (email=? or username=?) and LOWER(password)=?");
			$stmt->execute([$post['username'], $post['username'], $post['password']]);
			$result = $stmt->fetch();
			if(($result['username'] === $post['username'] || $result['email'] === $post['username'])){
				return true;
			}
			return false;
		}catch(Exception $e)
		{
			return $e->getMessage();
		}
		return false;
	}

	public static function close()
	{	self::$con = null;
		ConnectionBD::closeConnection();
	}


}

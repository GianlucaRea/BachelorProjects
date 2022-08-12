/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.company.pollweb.utility;

import java.sql.DriverManager;
import java.sql.*;

/**
 *
 * @author alessandrodorazio
 */
public class Database {
    
    public static Connection getConnection() throws ClassNotFoundException, SQLException{
        Class.forName("com.mysql.cj.jdbc.Driver");  
        java.sql.Connection con=DriverManager.getConnection("jdbc:mysql://localhost:3306/pollweb?serverTimezone=Europe/Berlin", "root", "root");
        return con;
    }
    
}

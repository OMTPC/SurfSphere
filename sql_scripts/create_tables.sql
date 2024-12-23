/*
 Title: SQL script to Drop and create tables 
 Created by: Orlando Caetano
 Date: 10/10/2024 
 Updated: 17/10/2024
 Discription: This SQL script is designed to reset the database by dropping the existing `members`, `posts`, `likes`, and `comments` tables, if they exist, 
              and then recreating them with updated structures. It includes user roles, member roles, and relationships between members, posts, likes, and 
              comments. The script also creates new `roles` and `member_roles` tables to manage user role assignments. 
              Each table has necessary foreign key constraints to ensure data integrity.
 Resourses: All the resources used are listed in <a href="../References.pdf" target="_blank">References</a>.see About page
*/


-- Drop the existing users table if it exists
DROP TABLE comments;
DROP TABLE likes;
DROP TABLE posts;
DROP TABLE members;


-- Create the new tables
CREATE TABLE members (
    membersID INT AUTO_INCREMENT PRIMARY KEY,
    userRole ENUM('admin', 'user') DEFAULT 'user',
    userName VARCHAR(100) NOT NULL UNIQUE,
    userEmail VARCHAR(255) NOT NULL,
    userPassword VARCHAR(300) NOT NULL,  
    joinDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE posts (
    postID INT AUTO_INCREMENT PRIMARY KEY,
    membersID INT,                  
    imagePath VARCHAR(255),         
    postText TEXT,                 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (membersID) REFERENCES members(membersID)  
);

CREATE TABLE likes (
    likeID INT AUTO_INCREMENT PRIMARY KEY,
    postID INT,
    membersID INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (postID) REFERENCES posts(postID),
    FOREIGN KEY (membersID) REFERENCES members(membersID)
);

CREATE TABLE comments (
    commentID INT AUTO_INCREMENT PRIMARY KEY,
    postID INT,
    membersID INT,
    commentText TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (postID) REFERENCES posts(postID),
    FOREIGN KEY (membersID) REFERENCES members(membersID)
);

CREATE TABLE roles (
    roleID INT AUTO_INCREMENT PRIMARY KEY,
    roleName VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE member_roles (
    memberID INT,
    roleID INT,
    PRIMARY KEY (memberID, roleID),
    FOREIGN KEY (memberID) REFERENCES members(membersID),
    FOREIGN KEY (roleID) REFERENCES roles(roleID)
);

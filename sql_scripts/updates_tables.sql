/*
 Title: SQL script to Drop and create tables 
 Created by: Orlando Caetano
 Date: 10/10/2024 
 Updated: 17/10/2024
 Discription: This SQL script alters the structure and content of the `members`, `comments`, `likes`, and `posts` tables. 
              It manages changes such as adding and dropping columns (profile picture, bio, surf stats), updating role management, 
              modifying foreign key constraints, and ensuring that any related data is deleted when a member is removed. 
              The script also includes operations to reset profile pictures, manage user roles, 
              and apply cascading deletion for related data in foreign key relationships.
 Resourses: All the resources used are listed in <a href="../References.pdf" target="_blank">References</a>.see About page
*/


-- these changes were constatly updating accordently to the develppment of the project
ALTER TABLE members ADD profile_picture VARCHAR(255) DEFAULT 'default_profile.jpg';

ALTER TABLE members 
DROP COLUMN profile_picture;

ALTER TABLE members 
ADD COLUMN bio VARCHAR(255) DEFAULT NULL,
ADD COLUMN surfStats VARCHAR(255) DEFAULT NULL;

ALTER TABLE members 
DROP COLUMN surfStats;

UPDATE members SET profilePicture = 'logo.png' WHERE profilePicture = 'default_profile.jpg';

ALTER TABLE members DROP COLUMN userRole;

INSERT INTO roles (roleName) VALUES ('admin'), ('user') 
ON DUPLICATE KEY UPDATE roleID=roleID; 

INSERT INTO member_roles (memberID, roleID)
SELECT m.membersID, r.roleID
FROM members m
JOIN roles r ON r.roleName = 'user'; 

SELECT membersID FROM members WHERE userName = 'OMTPC';

INSERT INTO member_roles (memberID, roleID) VALUES (13, 1);

ALTER TABLE comments DROP FOREIGN KEY comments_ibfk_2; 
ALTER TABLE likes DROP FOREIGN KEY likes_ibfk_2; 
ALTER TABLE posts DROP FOREIGN KEY posts_ibfk_1; 
ALTER TABLE member_roles DROP FOREIGN KEY member_roles_ibfk_1;

ALTER TABLE comments 
ADD CONSTRAINT comments_ibfk_2 
FOREIGN KEY (membersID) REFERENCES members(membersID) ON DELETE CASCADE;

ALTER TABLE likes 
ADD CONSTRAINT likes_ibfk_2 
FOREIGN KEY (membersID) REFERENCES members(membersID) ON DELETE CASCADE;

ALTER TABLE posts 
ADD CONSTRAINT posts_ibfk_1 
FOREIGN KEY (membersID) REFERENCES members(membersID) ON DELETE CASCADE;

ALTER TABLE member_roles 
ADD CONSTRAINT member_roles_ibfk_1 
FOREIGN KEY (memberID) 
REFERENCES members(membersID) 
ON DELETE CASCADE;

UPDATE members 
SET profilePicture = 'logo.png'
WHERE profilePicture IS NOT NULL; 

UPDATE members 
SET bio = NULL;

UPDATE members 
SET bio = null
WHERE bio IS NOT NULL;


ALTER TABLE comments
DROP FOREIGN KEY comments_ibfk_1;


ALTER TABLE comments
ADD CONSTRAINT comments_ibfk_1
FOREIGN KEY (postID) REFERENCES posts(postID)
ON DELETE CASCADE;


ALTER TABLE likes
DROP FOREIGN KEY likes_ibfk_1;


ALTER TABLE likes
ADD CONSTRAINT likes_ibfk_1
FOREIGN KEY (postID) REFERENCES posts(postID)
ON DELETE CASCADE;

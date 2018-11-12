Learn from: https://www.codeofaninja.com/2017/02/create-simple-rest-api-in-php.html

File Structure:  
├─ api/  
├─── config/  
├────── database.php - file used for connecting to the database.  
├─── objects/    
├────── User.php - contains properties and methods for "user" database queries.    
├────── Corkboard.php - contains properties and methods for "corkboard" database queries.  
├────── Pushpin.php - contains properties and methods for "pushpin" database queries.  
├────── Comment.php - contains properties and methods for "comment" database queries.  
├─── Login/  
├────── user.php- Start the session and get current user info, handle login input error.  
├─── Corkboard/   
├────── add_corkboard.php - file that will accept posted team057_p2_schema data to be saved to database.  
├────── delete_corkboard.php - file that will accept a corkboard ID to delete a database record.  
├────── view_one_corkboard.php - file that will accept a corkboard ID to output JSON data from "team057_p2_schema" database records, for view corkboard page  
├────── view_corkboard_img.php - file that will accept a corkboard ID to output JSON data from "team057_p2_schema" database records, for view corkboard page   
├────── search_corkboard.php - file that will accept keywords parameter to search "team057_p2_schema" database.  
├────── corkboard_statistic.php - file that output users' statistic info(public/private corkboard/pushpin num) by Json.  
├────── my_corkboard.php - file that output users' corkboard info by Json, for home page.  
├────── recent_corkboard.php - file that output recent corkboard info by Json, for home page.  
├─── pushpin/  
├────── add_pushpin.php - file that will accept posted "pushpin data to be saved to database.  
├────── delete_pushpin.php - file that will accept a "pushpin ID to delete a database record.  
├────── view_pushpin.php - file that will ccept a pushpin ID to output JSON data from "pushpin" database records.  
├────── search_pushpin.php - file that will accept keywords parameter to search "pushpin" database.  
├────── view_popular_site.php - file that output Json data from "team057_p2_schema" batebase.
├────── view_popular_tag.php - file that output Json data from "team057_p2_schema" datebase.    
├─── Comment/  
├────── add_comment.php - file that will  
├────── delete_comment.php - file that will accept a comment ID to delete a database record. 

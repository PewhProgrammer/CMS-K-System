/**
 * Created by Thinh-Laptop on 01.06.2017.
 */

var sql = "CREATE TABLE MyGuests ( id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY," +
    "firstname VARCHAR(30) NOT NULL,lastname VARCHAR(30) NOT NULL," +
    "email VARCHAR(50),reg_date TIMESTAMP)" ;

$( "#urlSubmit" ).click(function() {
    var frame = document.getElementById("iFrame");
    frame.style = 'block';
    frame.style.width = '100%' ;
    frame.style.height = '500px' ;
    frame.src = $('#urlInput').val();
});

$( "#urlAddDB" ).click(function() {
    $("#successDB").show();
});


checkURL = function(){

    var request = new XMLHttpRequest();
    request.open('GET', 'http://www.mozilla.org', true);
    request.onreadystatechange = function(){
        if (request.readyState === 4){
            if (request.status === 404) {
                alert("Oh no, it does not exist!");
            }
        }
    };
    request.send();
}


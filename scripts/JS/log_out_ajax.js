function log_out()
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = ()=>{location.reload()}
    xmlhttp.open("GET", "/TechTronic/scripts/log_out.php");
    xmlhttp.send();
}
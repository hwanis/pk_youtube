/**
 * Created by PhpStorm.
 * User: jangks
 * Date: 2018-05-25
 * Time: 오전 10:17
 */

function contents( loc_top ){

    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function() {
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
            document.getElementById("contents").innerHTML = xmlhttp.responseText;
        }
    }

    if( loc_top != 'n')
        xmlhttp.open("GET","floor.ajax.php?floor="+loc_top, true);
    else
        xmlhttp.open("GET","floor.ajax.php", true);
    xmlhttp.send();
}

//-->

function floors( loc_top, building ){

    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function() {
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
            document.getElementById("team").innerHTML = xmlhttp.responseText;
        }
    }

    xmlhttp.open("GET","depart.ajax.php?floor="+loc_top+"&build="+building, true);

    xmlhttp.send();
}


    function category( cate_top ){

        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function() {
            if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                document.getElementById("items").innerHTML = xmlhttp.responseText;
            }
        }

        xmlhttp.open("GET","category.ajax.php?cate_top="+cate_top, true);

        xmlhttp.send();
    }

function department( company_id ){

    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }  else   {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function() {
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
            document.getElementById("department").innerHTML = xmlhttp.responseText;
        }
    }

    xmlhttp.open("GET","../ajax/department.ajax.php?company_id="+company_id, true);
    xmlhttp.send();
}

<?php
//$data = $this->Generic_model->getData('com_det', array('cmne', 'synm'), array('stat' => 1));
$this->load->model('Generic_model'); // load model
$data = $this->Generic_model->getData('com_det', array('cmne', 'synm'), array('stat' => 1));

$url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//echo $url;
$re = (explode("/", $url));

if (!empty($re[3])) {
    $aa = $re[3];
    $pgdt = $this->Generic_model->getData('user_page', array('pgnm'), array('stst' => 1, 'pgcd' => $aa));

    if (sizeof($pgdt) > 0) {
        $pgnm = ' | ' . $pgdt[0]->pgnm;
    } else {
        $pgnm = '';
    }
} else {
    $pgnm = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!--<title>Boooya - Template</title>-->
    <title> <?= $data[0]->synm . $pgnm?> </title>

    <!-- META SECTION -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="<?= base_url(); ?>assets/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?= base_url(); ?>assets/img/favicon.ico" type="image/x-icon">
    <!-- END META SECTION -->
    <!-- CSS INCLUDE -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/styles.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/custom-css/common.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/jquery-validation/css/screen.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/glyphicon_icon.css">
<!--    https://github.com/Eonasdan/bootstrap-datetimepicker-->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css">
    <!-- EOF CSS INCLUDE -->
</head>
<body>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/jquery/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/bootstrap/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/moment/moment.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/custom-js/custom-validation.js"></script>


<script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery.userTimeout.js"></script>
<script type="text/javascript">  // common function
    $(document).userTimeout({
        logouturl: '<?= base_url() ?>welcome/auto_lgout',
        session: 900000 //15 Minutes    1's= 1000ms  // 900000
    });

    //SYSTEM DATE TIME
    var weekdaystxt = ["Sun", "Mon", "Tues", "Wed", "Thu", "Fri", "Sat"]

    function showLocalTime(container, servermode, offsetMinutes, displayversion) {
        if (!document.getElementById || !document.getElementById(container)) return
        this.container = document.getElementById(container)
        this.displayversion = displayversion
        var servertimestring = (servermode == "server-php") ? '<?php print date("F d, Y H:i:s", time())?>' : (servermode == "server-ssi") ? '<!--#config timefmt="%B %d, %Y %H:%M:%S"--><!--#echo var="DATE_LOCAL" -->' : '<%= Now() %>'
        this.localtime = this.serverdate = new Date(servertimestring)
        this.localtime.setTime(this.serverdate.getTime() + offsetMinutes * 60 * 1000) //add user offset to server time
        this.updateTime()
        this.updateContainer()
    }

    showLocalTime.prototype.updateTime = function () {
        var thisobj = this
        this.localtime.setSeconds(this.localtime.getSeconds() + 1)
        setTimeout(function () {
            thisobj.updateTime()
        }, 1000) //update time every second
    }

    showLocalTime.prototype.updateContainer = function () {
        var thisobj = this
        if (this.displayversion == "long")
            this.container.innerHTML = this.localtime.toLocaleString()
        else {
            var hour = this.localtime.getHours()
            var minutes = this.localtime.getMinutes()
            var seconds = this.localtime.getSeconds()
            var ampm = (hour >= 12) ? "PM" : "AM"
            var dayofweek = weekdaystxt[this.localtime.getDay()]
            this.container.innerHTML = formatField(hour, 1) + ":" + formatField(minutes) + ":" + formatField(seconds) + " " + ampm + " (" + dayofweek + ")"
        }
        setTimeout(function () {
            thisobj.updateContainer()
        }, 1000) //update container every second
    }

    function formatField(num, isHour) {
        if (typeof isHour != "undefined") { //if this is the hour field
            var hour = (num > 12) ? num - 12 : num
            return (hour == 0) ? 12 : hour
        }
        return (num <= 9) ? "0" + num : num//if this is minute or sec field
    }

    //END SYSTEM DATE TIME

    // CURRENT TIME WITH NOTIFICATION CHECK
    timedMsg();

    function timedMsg() {
        setInterval("change_time();", 1000);
    }

    var servertimestring = ("server-php" == "server-php") ? '<?php print date("F d, Y H:i:s", time())?>' : ("server-php" == "server-ssi") ? '<!--#config timefmt="%B %d, %Y %H:%M:%S"--><!--#echo var="DATE_LOCAL" -->' : '<%= Now() %>'
    this.localtime = this.serverdate = new Date(servertimestring)
    this.localtime.setTime(this.serverdate.getTime() + 0 * 60 * 1000) //add user offset to server time
    updateTime2();
    updateContainer2();

    function updateTime2() {
        var thisobj = this
        this.localtime.setSeconds(this.localtime.getSeconds() + 1)
        setTimeout(function () {
            updateTime2()
        }, 1000) //update time every second
    }

    function updateContainer2() {
        var thisobj = this
        if (this.displayversion == "long")
        //this.container.innerHTML = this.localtime.toLocaleString()
            var ttm = this.localtime.toLocaleString()
        else {
            var hour = this.localtime.getHours()
            var minutes = this.localtime.getMinutes()
            var seconds = this.localtime.getSeconds()
            var ampm = (hour >= 12) ? "PM" : "AM"
            var dayofweek = weekdaystxt[this.localtime.getDay()]
            //this.container.innerHTML = formatField(hour, 1) + ":" + formatField(minutes) + ":" + formatField(seconds) + " " + ampm + " (" + dayofweek + ")"
            var ttm = formatField(hour, 1) + ":" + formatField(minutes) + ":" + formatField(seconds) + " " + ampm
        }
        return ttm
    }

    function change_time() {
        if (navigator.onLine) {
            document.getElementById("chk_cnntion").innerHTML = "<span class='label label-success label-form1'>ONLINE</span>";
        } else {
            document.getElementById("chk_cnntion").innerHTML = "<span class='label label-danger label-form1'>OFFLINE</span>";
        }
        var svtm = updateContainer2();                  // SERVER TIME
        var crtm = new Date().toLocaleTimeString();     // LOCAL TIME
        //console.log(crtm + ' -- ' + svtm);

        if (svtm === '10:55:00 PM') {
            //swal({title: "Reminder", text: "Please finish all work before 11 PM and quit..", type: "info"});
            $('#schInfo').toggleClass("open");
        }
        else if (svtm === '11:00:00 PM') {
            document.getElementById('msg_timout').innerHTML = "Your working times is over now.. \n Log Again Tomorrow.";
            $('#timOut').toggleClass("open");
            return false;
        }
        //else if (crtm === '10:00:00 AM') {
        //    swal({title: "Schedule time", text: "Please give me a few minutes.", type: "info"},
        //        function () {
        //            window.location.href = '<?//= base_url() ?>//She_night';
        //        });
        //}

        // MIDNIGHT LOG USER AUTO OUT  >> http://jsfiddle.net/L2y2d/1/
        var time = svtm;
        var hours = Number(time.match(/^(\d+)/)[1]);
        var minutes = Number(time.match(/:(\d+)/)[1]);
        var AMPM = time.match(/\s(.*)$/)[1];
        if (AMPM == "PM" && hours < 12) hours = hours + 12;
        if (AMPM == "AM" && hours == 12) hours = hours - 12;
        var sHours = hours.toString();
        var sMinutes = minutes.toString();
        if (hours < 10) sHours = "0" + sHours;
        if (minutes < 10) sMinutes = "0" + sMinutes;
        //alert(sHours + ":" + sMinutes);
        var ntm = sHours + ":" + sMinutes;

        if (ntm > '23:00' && svtm < '23:58') {
            //console.log(svtm + ' ** ' + ntm + ' AAA');
            window.location.href = '<?= base_url() ?>welcome/schedule_lgout';
        } else {
            //console.log(svtm + ' ** ' + ntm);
        }
        // END MIDNIGHT LOG USER AUTO OUT
    }

    // end system time show function

</script>

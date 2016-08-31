<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Jaguar Test</title>
    </head>
    <body>

<?php

    class Crimesearch {

        /**
         * Set results
         *
         * @var $result
         */

        public $result;

        public function __construct() {

             $this->lat = isset($_POST['lat']) ? $_POST['lat'] : null;
             $this->lng = isset($_POST['lng']) ? $_POST['lng'] : null;

             $this->result = json_decode($this->fetch('https://data.police.uk/api/crimes-at-location?lat='.$this->lat.'&lng='.$this->lng));

        }

        public function fetch($url) {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            $result = curl_exec($ch);
            curl_close($ch);

            return $result;

        }

    }

    /* Initialise Instagram */
    $report = new Crimesearch();

?>

<div class="crimesearch">

    <form action="" method="POST" >
        <p>
            <input type="text" name="lat" required="" id="lat" value="" class="formbox" placeholder="Latitude" autocomplete="off">
            <input type="text" name="lng" required="" id="lng" value="" class="formbox" placeholder="longitude" autocomplete="off">
            <button type="submit" class="btn btn--green" title="Submit">Submit</button>
        </p>
    </form>

    <? if(!empty($_POST) && isset($report->result)): ?>

        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>


            <? foreach ($report->result as $key => $data): ?>

                <td><? var_dump($data); ?></td>

           <? endforeach; ?>


            </tbody>
        </table>

    <? else: ?>

        <p>Please enter a location to search for</p>

    <? endif; ?>

    <div id="currentPos"></div>

</div>

<script type="text/javascript">
    var currentPos = document.getElementById('currentPos');

    var options = {
      enableHighAccuracy: true,
      timeout: 5000,
      maximumAge: 0
    };

    function success(pos) {
        var crd = pos.coords;
        currentPos.innerHTML ='<p>Latitude : ' + crd.latitude + '</p><p>Longitude: ' + crd.longitude + '</p><p>Accuracy is within ' + crd.accuracy + ' meters.</p>';
    };

    function error(err) {
        currentPos.innerHTML = 'ERROR(' + err.code + '): ' + err.message;
    };

    navigator.geolocation.getCurrentPosition(success, error, options);
</script>

    </body>
</html>

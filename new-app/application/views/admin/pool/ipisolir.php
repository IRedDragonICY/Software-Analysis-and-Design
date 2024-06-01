<!DOCTYPE html>

<head>
    <title><?= $title ?></title>
</head>

<body>

    <?php

    foreach ($data->result() as $row) {
        $iprange = $row->ip_range;
        $cidr = $row->cidr;

        $range = 254;

        $x = 2;

        $host = $x - 2;

        $hostnya = $iprange . $host . $cidr;

        echo "/ip firewall address-list <br>";


        for ($i = $x; $i <= $range; $i++) {
            echo "add address=" . $iprange . $i . " list=ISOLIR<br>";
        }
    }


    ?>

</body>

</html>
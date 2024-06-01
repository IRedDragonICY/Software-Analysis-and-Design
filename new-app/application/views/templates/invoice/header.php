<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran Invoice </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link id="style" href="<?php echo base_url() ?>/assets/plugins/bootstrap/css/bootstrap.custom.min.css" rel="stylesheet" />

    <style>
        @media only screen and (max-width: 600px) {
            .memberdetail {
                margin-left: 1px;
            }

            .mob1 {
                margin-top: 5px !important;
            }
        }

        body {
            padding-top: 80px;
            background-image: url("<?php echo base_url() ?>/assets/images/colorfull.jpg");

        }

        button.accordion {
            width: 100%;
            background-color: #0d6efd;
            color: #fff;
            border: none;
            outline: none;
            text-align: left;
            padding: 0.5em 1em;
            font-size: 1.2em;
            cursor: pointer;
            transition: background-color 0.2s linear;
            display: flex;
        }

        button.accordion:hover {
            background-color: #0b5ed7;
        }

        .accordion-content {
            padding: 0 1em;
            height: 0;
            overflow: hidden;
            transition: height 0.2s ease-out;
        }

        button div .arrow {
            border: solid #fff;
            border-width: 0 4px 4px 0;
            display: inline-block;
            padding: 3px;
            transform: rotate(-135deg);
            transition: transform 0.3s ease-out;
        }

        .btnarrow {
            margin: auto 0 auto auto;
        }
    </style>
</head>

<body>
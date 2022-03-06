<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title><?php echo $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gothic+A1&display=swap" rel="stylesheet">

    <link rel="icon" href="<?php echo base_url('assets/favicon.png') ?>" type="image/gif">

</head>

<body style="margin: 0; font-family: sans-serif;">

    <div style="width: 480px; height: 670px;">
        <div style="padding: 1.5em 2em; background-color: white; border-radius: 10px;">
            <div style="margin: 0 0 1em 0;">
                <span style="font-size: 1.6rem;"><?php echo $today ?> (<?php echo $day_week ?>) <?php echo $cur_time ?></span>
            </div>
            <div style="margin: 1.8em 0 2em 0;text-align: center; border: 5px solid black; padding: 1em 0; border-radius: 5px;">
                <span style="font-size: 3rem; font-weight: bold; letter-spacing: 10px;"><?php echo $box_name ?></span>
            </div>
            <div style="text-align: center;margin: 1em 0;padding: 1em 0;background-color: black; color: white; border-radius: 5px;">
                <span style="font-size: 10rem;"><?php echo $col_name ?><span style="font-size: 5rem; margin: 0.2em;
">列</span><?php echo $row_name ?></span>
            </div>
            <div style="margin: 2.5em 0;text-align: right;">
                <span style="font-size: 2rem;"><?php echo $fee ?> 円</span>
            </div>
            <div style="margin: 1em 0 0 0;text-align: center;">
                <p style="font-size: 2.1rem; font-weight: bold; letter-spacing: 3px; margin: 0;"><?php echo $help_text1 ?></p>
                <p style="font-size: 2.1rem; font-weight: bold; letter-spacing: 3px; margin: 0;"><?php echo $help_text2 ?></p>
            </div>

        </div>
    </div>

</body>
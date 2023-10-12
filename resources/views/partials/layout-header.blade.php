<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>Trisflix</title>
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script>
        $(function () {
            $("[id^=all_]").click(function (index) {
                if($(this).not(this).prop('checked', this.checked)) {
                    $('.' + $(this).attr("id")).prop('checked', true);
                } else {
                    $('.' + $(this).attr("id")).prop('checked', false);
                }
            });
        });
    </script>
</head>
<body>

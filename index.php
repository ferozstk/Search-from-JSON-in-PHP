<?php error_reporting (E_ALL ^ E_NOTICE); ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search Script</title>

    <style>
        body{
            margin: auto;
        }
        .results{
            display: flex;
            flex-direction: column;
            width: 70%;
            margin: auto;
            margin-top: 20vh;
        }
        .result-head{
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
        }
        .result-head .copy{
            border: 1px solid gray;
            padding: 4px 12px;
            border-radius: 3px;
            cursor: pointer;
        }
        .result-head .copy:hover{
            background-color: gray;
        }
        textarea{

        }

        form{
            display: grid;
            grid-template-columns: 79% 20%;
            grid-gap: 1%;
            flex-direction: row;
            width: 70%;
            margin: auto;
            margin-top: 20vh;
        }
        form select,
        form input{
            padding: 0.618rem;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        function copyToClipboard() {
            const elem = document.getElementById('codes');
            elem.select();
            document.execCommand('copy');

            document.getElementById('copyNow').innerHTML = '√ Copied';

            setTimeout(
                function() {
                    document.getElementById('copyNow').innerHTML = 'Copy to clip board';
                }, 3000);
        }
    </script>

    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
</head>
<body>

    <?php
    $str = file_get_contents('./utilityzip.json');
    $json = json_decode($str, true);
    $items = $json['items'];

    if($_GET['s']){
        $s = $_GET['s'];


        foreach ($items as $i){
            if(strtoupper($i['fields']['name']) == strtoupper($s)){
                $selected = $i['fields']['zipcodes'];
                break;
            }
        }

//        echo '<PRE>'; print_r(count($selected)); echo '</PRE>';
//        echo '<PRE>'; print_r($selected); echo '</PRE>';
    }

    if($selected){ ?>

        <div class="results">
            <a href="index.php">New search</a>
            <br>
            <div class="result-head">
                <div class="total-found">
                    <?php echo 'Total found <b>'.count($selected).'</b> for <u>'.$s.'</u>';?>
                </div>
                <div class="copy" id="copyNow" onclick="copyToClipboard()">Copy to clip board</div>
            </div>
            <textarea name="" id="codes" cols="30" rows="10"><?php echo implode(', ', $selected)?></textarea>
        </div>
    <?php }else{
        ?>
        <form action="">
<!--            <input type="search" autofocus="autofocus" placeholder="Search by name..." name="s" id="">-->
            <select class="js-example-basic-single" placeholder="Search by name..." name="s" required>
                <option value="">Search by name...</option>
                <?php
                foreach ($items as $i){ ?>
                    <option value="<?php echo $i['fields']['name']; ?>"><?php echo $i['fields']['name']; ?></option>
                <?php } ?>
            </select>
            <button type="submit">Search</button>
        </form>
        <?php
    }


    ?>

</body>
</html>
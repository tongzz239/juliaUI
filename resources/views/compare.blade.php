<!DOCTYPE html>
<html>
  <head>
    <link rel="mask-icon" href="{{ asset('img/j.svg') }}">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <style type="text/css">
      body, html {
        margin: 0;
        overflow: hidden;
        height:100%;
      }
      #top {
        height:10%;
        position: absolute;
        top: 0%;
        bottom: 0;
        right: 0;
      }
      #left {
        height:90%;
        position: absolute;
        top: 10%;
        bottom: 0;
        left: 0;
        overflow-y: auto; 
      }

      #right {
        height:90%;
        position: absolute;
        top: 10%;
        bottom: 0;
        right: 0;
        overflow-y: auto;
        overflow-x: auto;
      }
    </style>
  </head>
  <body>
    <div class="row">
      <div class="col"><? echo $highlighted1[1] ?></div>
      <div class="col"><? echo $highlighted2[1] ?></div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-sm-6" id="left">
          <? echo $highlighted1[0] ?>
        </div>   
        <div class="col-sm-6" id="right">
          <? echo $highlighted2[0] ?>
        </div>
      </div>
    </div>
  </body>
</html>

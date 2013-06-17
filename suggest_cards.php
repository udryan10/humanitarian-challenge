<?php ?>
<!-- html for start of game -->
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
  <script src= "./javascript/jquery.cookie.js"></script>
  <script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
</head>

<body>
  <div data-role="page" id='register'>
    <div data-role="header">
      <h1>Humanitarian Challenge - Submit Cards</h1>
    </div><!-- /header -->
    <div data-role="content">
      <form>
        <div data-role="fieldcontain">
          <label for="textarea">White Card:</label>
            <textarea name="textarea" id="textarea"></textarea>
        </div>
      </form>     
    </div>
  </div>
</body>
</html>

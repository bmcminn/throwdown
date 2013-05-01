<?php

  require_once('app/libs/markdown/markdown.php');



  // print_r($APP_CONFIG);

  $copy = <<<MDOWN


Welcome to Throwdown!
=====================

Overall this whole process is _REALLY_ simple. Fill out the details below and press submit. That's it!

These options will be written to your `config.json` file which is only accessible via FTP or directly editing it in your local file system.

For security reasons, I've disabled viewing of `.json` data directly within the browser, so unless you have root access no one is getting a peak at your config.

---

MDOWN;


  $instructions = Markdown($copy);

  // Set date for today
  $installDate  = date('m/d/Y');

?><!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Throwdown Installation Guide</title>
  <link rel="stylesheet" href="app/css/install.css">
</head>
<body>

  <div id="message" class="container">

    <?php echo $instructions; ?>

    <form class="config-form" data-validate="parsley" method="POST" action="install.php">
      <input type="hidden" name="hiddenInstallID" value="installing">
      <input type="hidden" name="installed" value="<?php echo $installDate; ?>">


    <!-- GENERAL INFO -->
      <label for="blogName">Blog Name</label>
      <input type="text" name="blogName" id="blogName" value="" required>

      <label for="userName">User Name</label>
      <input type="text" name="userName" id="userName" value="" required>

      <label for="preferredLang">Language</label>
      <select type="text" name="preferredLang" id="preferredLang" value="" required>
        <option>--- Preferred Language ---</option>
        <option value="" selected>Enlish</option>
        <option value="">Chinese</option>
        <option value="">Italian</option>
        <option value="">Japanese</option>
        <option value="">Korean</option>
        <option value="">Portuguese</option>
        <option value="">Russian</option>
        <option value="">Spanish</option>
        <option value="">Vietnamese</option>

      </select>


    <!-- TWITTER -->
      <label for="twitterName">Twitter Handle</label>
      <input type="text" name="twitterName" id="twitterName" value="">

      <label for="twitterSecret">Twitter Secret</label>
      <input type="text" name="twitterSecret" id="twitterSecret" value="">


    <!-- FACEBOOK -->
      <label for="facebookPage">Facebook Page</label>
      <input type="text" name="facebookPage" id="facebookPage" value="">

      <label for="facebookSecret">Facebook Secret</label>
      <input type="text" name="facebookSecret" id="facebookSecret" value="">

      <label for="facebookKey">Facebook Key</label>
      <input type="text" name="facebookKey" id="facebookKey" value="">


    <!-- SUBMIT -->
    <button type="submit" id="submit" class="submit-button">Submit</button>


    </form><!-- #config-form -->

  </div>


  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
  <script src="app/js/libs/forms/parsely.min.js"></script>
  <script src="app/js/libs/forms/garlic.min.js"></script>
  <script src="app/js/plugins.js"></script>
</body>
</html>
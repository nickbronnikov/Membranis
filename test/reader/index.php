<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/libs/jquery.min.js"></script>

        <script src="js/libs/zip.min.js"></script>
        <script src="/js/jquery-3.1.0.min.js"></script>
        <script src="/js/script.js"></script>
        <script>
            "use strict";

            document.onreadystatechange = function () {
              if (document.readyState == "complete") {
                EPUBJS.filePath = "js/libs/";
                EPUBJS.cssPath = window.location.href.replace(window.location.hash, '').replace('index.php', '') + "css/";
                // fileStorage.filePath = EPUBJS.filePath;

                window.reader = ePubReader("http://membranis.com/Blue.epub");
              }
            };

        </script>

        <!-- File Storage -->
        <!-- <script src="js/libs/localforage.min.js"></script> -->

        <!-- Full Screen -->
        <script src="js/libs/screenfull.min.js"></script>

        <!-- Render -->
        <script src="js/epub.min.js"></script>

        <!-- Hooks -->
        <script src="js/hooks.min.js"></script>

        <!-- Reader -->
        <script src="js/reader.min.js"></script>

        <!-- Plugins -->
        <!-- <script src="js/plugins/search.js"></script> -->

        <!-- Highlights -->
        <!-- <script src="js/libs/jquery.highlight.js"></script> -->
        <!-- <script src="js/hooks/extensions/highlight.js"></script> -->

    </head>
    <body>
    <div style="width: 100%; height: 50px"><h1>Test</h1></div>
    <div style="width: 100%;">
    <div id="sidebar">
        <div id="tocView" class="view">
        </div>
    </div>
    <div id="main">

        <div id="titlebar">
            <div id="opener">
                <a id="slider" class="icon-menu">Menu</a>
            </div>
        </div>

        <div id="divider"></div>
        <div id="prev" class="arrow" onclick="hashDel()">‹</div>
        <div id="viewer"></div>
        <div id="next" class="arrow" onclick="hashDel()">›</div>

        <div id="loader"><img src="img/loader.gif"></div>
    </div>
    <div class="overlay"></div>
    </div>
    </body>
</html>



When you type in http://www.your-site.com/tv/something

.htaccess will refer that request to this index.php file, and call it:

index.php?page_uri=something


To change the way the page looks, open index.php and make changes there.

You can add your own HTML before and after the video page HTML.

For example, you can add your own branding, header, menu and footer to the page.



To make your videos appear on your own website, simple include the get_page.php file wherever you want it to appear on your site.

Example include command using PHP:

<? include_once('includes/get_page.php'); ?>

You would normally put your own header and menu first, then call this file using the command above, then your own footer.

Example:

Your header HTML code goes here.
Your menu HTML code goes here.
<? include_once('get_page_html.php'); ?>
Your footer HTML code goes here.

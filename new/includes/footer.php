<footer data-role="footer">
    <ul>
        <li><a id="feedback" target="_blank" href="#">Feedback</a></li>
        <li><a target="_blank" href="http://www.artofbeerbrewery.com">Made by Art of Beer Brewery</a></li>
        <li>&copy; 2013</li>
    </ul>
</footer>

<script src="/js/plugins/jquery.min.js"></script>
<script src="/js/plugins/jQuery.serializeObject.js"></script>
<script src="/js/main.js"></script>
<script>
    // Include the UserVoice JavaScript SDK (only needed once on a page)
    UserVoice=window.UserVoice||[];(function(){var uv=document.createElement('script');uv.type='text/javascript';uv.async=true;uv.src='//widget.uservoice.com/npYI91PM1QHuevJXxZllCg.js';var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(uv,s)})();

    // Set colors
    UserVoice.push(['set', {
        accent_color: '#448dd6',
        trigger_color: 'white',
        trigger_background_color: 'rgba(46, 49, 51, 0.6)'
    }]);

    // Identify the user and pass traits
    // To enable, replace sample data with actual user traits and uncomment the line
    UserVoice.push(['identify', {
        <?php if (isset($user)) {
            print "email:      '" . $user -> getEmail() . "'";
         }
        ?>
    }]);

    // Add default trigger to the bottom-right corner of the window:
    UserVoice.push(['addTrigger', { mode: 'contact', trigger_position: 'bottom-right' }]);

    // Or, use your own custom trigger:
    UserVoice.push(['addTrigger', '#feedback', { mode: 'contact' }]);

    // Autoprompt for Satisfaction and SmartVote (only displayed under certain conditions)
    UserVoice.push(['autoprompt', {}]);
</script>
#! /bin/sh

# 合并css
cd /home/www/yeap/app/static/css/source
#
awk '{print $0}' bootstrap-cerulean.css bootstrap-responsive.css > ../merge/bootstrap.css
#
awk '{print $0}' charisma-app.css fullcalendar.css fullcalendar.print.css chosen.css uniform.default.css colorbox.css jquery.cleditor.css jquery.noty.css noty_theme_default.css elfinder.min.css elfinder.theme.css jquery.iphone.toggle.css opa-icons.css uploadify.css > ../merge/plugin.css

cat jquery-ui-1.8.21.custom.css > ../merge/jquery-ui.css

cd ../merge
find -name "*.css" -exec 'cat' {} \; > ../main.css

# 合并js
cd /home/www/yeap/app/static/js/source
awk '{print $0}' bootstrap-transition.js bootstrap-alert.js bootstrap-modal.js bootstrap-dropdown.js bootstrap-scrollspy.js bootstrap-tab.js bootstrap-tooltip.js bootstrap-popover.js bootstrap-button.js bootstrap-collapse.js bootstrap-carousel.js bootstrap-typeahead.js bootstrap-tour.js> ../merge/bootstrap.js

#
awk '{print $0}' jquery.cookie.js jquery.dataTables.min.js fullcalendar.min.js jquery.chosen.min.js jquery.uniform.min.js jquery.colorbox.min.js jquery.cleditor.min.js jquery.noty.js jquery.elfinder.min.js jquery.raty.min.js jquery.iphone.toggle.js jquery.autogrow-textarea.js jquery.uploadify-3.1.min.js jquery.history.js > ../merge/plugin.js

#
awk '{print $0}' excanvas.js jquery.flot.min.js jquery.flot.pie.min.js jquery.flot.stack.js jquery.flot.resize.min.js  > ../merge/chart.js

cat charisma.js > ../merge/charisma.js

cat jquery-1.7.2.min.js > ../merge/jquery.min.js

cat jquery-ui-1.8.21.custom.min.js > ../merge/jquery-ui.custom.min.js

cd ../merge
find -name "*.js" -exec 'cat' {} \; > ../main.js


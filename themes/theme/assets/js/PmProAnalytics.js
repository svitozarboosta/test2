var PmProAnalytics = function () {

    var self = {

        // On load CheckOutPage
        initCheckOutPage: function(options) {
            ga('ec:addImpression', {
                'id': options.currentLevelId,
                'name': options.currentLevelDays
            });
            ga('send', 'pageview', '/account/levels/view/' + options.currentLevelDays);

            // Click action on register button
            $('.' + options.el_register_button).click(function () {
                ga('ec:setAction','checkout', {
                    'step': 1,
                    'option': 'registration'
                });
                ga('ec:addProduct', {
                    'id': options.currentLevelId,
                    'name': options.currentLevelDays,
                    'price': options.currentLevelPrice,
                    'quantity': 1
                });

                ga('send', 'pageview', '/account/levels/' + options.currentLevelDays +'/registrations');
            });

            // Click action on paypal button
            $('.' + options.el_checkout_button).click(function () {
                ga('ec:addProduct', {
                    'id': options.currentLevelId,
                    'name': options.currentLevelDays,
                    'category': options.paymentCounter,
                    'brand': 'paying by card', // TODO_S: Don't know that
                    'variant': '1', // TODO_S: Need interested
                    'price': options.currentLevelPrice,
                    'quantity': 1
                });

                ga('ec:setAction','checkout', {'step': 2});
                ga('send', 'pageview', '/account/levels/' + options.currentLevelDays + '/paypal-click');

            });
        },

        // On load Levels page
        initLevelsPage: function (options) {
            options.levels.forEach(function (item, index) {
                ga('ec:addImpression', {
                    'id': item.id,
                    'name': item.name,
                    'list': 'Level Page',
                    'position': index + 1
                });
            });
            ga('send', 'pageview');

            // Click action on get level button
            $('.' + options.el_level_button).click(function () {
                var level_button_href = $(this).attr('href');
                var level_id = self.getParameterByName('level', level_button_href);

                options.levels.forEach(function (item, index) {
                    if (item.id === 'P' + level_id) {
                        ga('ec:addProduct', {
                            'id': item.id,
                            'name': item.name,
                            'list': 'Level Page',
                            'position': index + 1
                        });

                        ga('ec:setAction', 'click', {list: 'subject'});
                        ga('send', 'pageview', '/account/levels/click/' + item.name);
                    }
                });
            });
        },

        getParameterByName: function (name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }

    };

    // Share variable & methods
    this.initCheckOutPage = self.initCheckOutPage;
    this.initLevelsPage = self.initLevelsPage;

};
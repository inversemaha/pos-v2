var app = angular.module('sposApp', ['toaster', 'ui.bootstrap', ]);
app.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[-');
    $interpolateProvider.endSymbol('-]');
});

app.factory("resourceCache",["$cacheFactory",
    function($cacheFactory) {
        return $cacheFactory("resourceCache");
    }
]);


app.directive("preloadResource", ["resourceCache",
    function(resourceCache) {
        return { link: function (scope, element, attrs) {
                resourceCache.put(attrs.preloadResource, element.html());
            }};
    }
]);
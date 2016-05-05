angular.module('guestApp.controller', []).
    controller('guestListController', function($scope, guestListService) {
        var vm = $scope;

        function getNumRsvp(data){
            var guests = 0;
            data.filter(function(guest){
               guests = guests + parseInt(guest.num_guests);
            });
            return guests;
        }

        function init(){
            var promise = guestListService.getGuests();
            promise.then(function(response){
                var data = response.data;
                vm.rsvp = data.length;
                vm.data = data;
                vm.num_rsvp = getNumRsvp(data);
            });
        }

        init();
    })
    .service('guestListService', function($http){
        var vm = this;
        vm.getGuests = getGuests;
        
        function getGuests(){
            var url = '/getGuests.php';
            return $http({
                method: 'POST',
                url: url
            })
        }
    });
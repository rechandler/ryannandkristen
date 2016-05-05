angular.module('weddingApp.controller', []).
controller('weddingAppController', function($scope, weddingAppService) {
    var vm = this;
    vm.template = "./assets/views/start.template.html";
    vm.code = null;
    vm.selectedNumberOfGuests = null;
    vm.comments = "";
    vm.codeError = false;
    vm.submissionError = false;
    vm.responseError = false;
    vm.rsvpError = false;

    vm.submitCode = submitCode;
    vm.submitRSVP = submitRSVP;

    function submitRSVP(){
        var data = buildData();
        var promise = weddingAppService.submitGuestInfo(data);

        promise.then(function(response){
            if(response.data.error){
                vm.rsvpError = true;
            } else {
                vm.rsvpError = false;
                vm.endData = response.data[0];
                vm.template = "./assets/views/third.template.html";
            }
        });

    }

    function buildData(){
        return {
            name: vm.secondData.name,
            numGuests: vm.selectedNumberOfGuests,
            comments: vm.comments,
            id: vm.secondData.id
        }
    }

    function getNumGuestsFromData(data){
        //test
        var result = [];
        var num = parseInt(data[0].num_guests);
        for(var i = 0; i <= num; i++){
            if(i === 0){
                result[i] = '0 - Not Attending :( ';
            }else {
                result[i] = i;
            }
        }

        return result;
    }

    function submitCode(){
        if(vm.code && vm.code !== "") {
            vm.codeError = false;
            var promise = weddingAppService.submitCode(vm.code);

            promise.then(function(response){
                if(response && response.data && response.data.length > 0){
                    vm.responseError = false;
                    vm.submissionError = false;
                    vm.secondData = response.data[0];
                    vm.secondOptions = getNumGuestsFromData(response.data);
                    vm.template = "./assets/views/second.template.html";
                } else {
                    vm.responseError = true;
                }
            },function(err){
                vm.submissionError = true;
            });
        } else {
            vm.codeError = true;
        }
    }
}).
service('weddingAppService', function($http){
    var vm = this;
    vm.submitCode = submitCode;
    vm.submitGuestInfo = submitGuestInfo;

    function submitCode(code){
        //dev
        //var server = 'http://localhost:63334/server.php';
        //prod
        var server = '/server.php';
        if(code && code !== ""){
            return $http({
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                data: {data: code},
                url: server
            });
        } else {
            alert('no code entered');
        }
    }

    function submitGuestInfo(data){
        //dev
        //var server = 'http://localhost:63334/submitGuests.php';
        //prod
        var server = '/submitGuests.php';
        return $http({
            method: 'POST',
            url: server,
            data: data
        });
    }
});
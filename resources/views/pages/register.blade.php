@include('templates.header')
<h3 class="text-center">USER REGISTRATION</h3>
<hr>
<div class="col-md-6 col-md-offset-3" ng-controller="UserRegistration">

    <div class="form-group">
        <label for="inputFirstName">First Name</label>
        <input type="text" class="form-control" id="inputFirstName" placeholder="First Name"
            ng-model="firstname" ng-required="string" ng-minlength="1" ng-maxlength="255" ng-trim="1">
    </div>

    <div class="form-group">
        <label for="inputLastName">Last Name</label>
        <input type="text" class="form-control" id="inputLastName" placeholder="Last Name"
            ng-model="lastname" ng-required="string" ng-minlength="1" ng-maxlength="255" ng-trim="1">
    </div>

    <div class="form-group">
        <label for="inputEmailAddress">Email Address</label>
        <input type="email" class="form-control" id="inputEmailAddress" placeholder="Email Address"
            ng-model="email" ng-required="email" ng-pattern="emailFormat" ng-minlength="1" ng-maxlength="255" ng-trim="1">
    </div>

    <div class="form-group">
        <label for="inputContactNumber">Contact Number</label>
        <input type="number" class="form-control" id="inputContactNumber" placeholder="Contact Number"
            ng-model="contactNumber" ng-required="number" ng-minlength="1" ng-maxlength="10" ng-trim="1">
    </div>

    <div class="well">
        <div class="form-group">
            <label for="inputUserName">Username</label>
            <input type="text" class="form-control" id="inputUserName" placeholder="Username"
                ng-model="username" ng-required="string" ng-minlength="1" ng-maxlength="255" ng-trim="1">
        </div>

        <div class="form-group">
            <label for="inputPassword">Password</label>
            <input type="password" class="form-control" id="inputPassword" placeholder="Password"
                ng-model="password" ng-required="string" ng-minlength="1" ng-maxlength="255" ng-trim="1">
        </div>

        <div class="form-group">
            <label for="inputRepeatPassword">Repeat Password</label>
            <input type="password" class="form-control" id="inputRepeatPassword" placeholder="Repeat Password"
                ng-model="password" ng-required="string" ng-minlength="1" ng-maxlength="255" ng-trim="1">
        </div>
    </div>

</div>
@include('templates.footer')

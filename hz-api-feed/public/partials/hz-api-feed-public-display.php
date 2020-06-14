<?php

/**
 * @link       https://facebook.com/humayoon.zahoor
 * @since      1.0.0
 *
 * @package    Hz_Api_Feed
 * @subpackage Hz_Api_Feed/public/partials
 */
?>
<div ng-app="hzCharities" ng-controller="hzCharitiesController" data-ng-init="init()">
	<style scoped>
		@import "<?php echo plugin_dir_url( dirname( __FILE__ ) ) ?>css/bootstrap/bootstrap.min.css";

	</style>
	<form class="form-inline">
		<div class="col-auto my-1">
      <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Search By: </label>
      <select ng-model="selectedSearchType" class="custom-select mr-sm-2" id="inlineFormCustomSelect">
        <option value="Keyword">Search by Keyword</option>
        <option value="Name">Search by Name</option>
        <option value="RegID">Search by Registration ID</option>
      </select>
    </div>
		
	
			<div class="col-auto my-1">
				<label for="hzSearchInput" class="sr-only">Search </label>
				<input id="hzSearchInput" type="search" class="form-control" ng-model="keyword" ng-change="search()" ng-enter="search()" placeholder="Type {{selectedSearchType}} here ...">

			</div>

	
		<?php // <button type="submit" class="btn btn-primary mb-2" ng-click="search()"><i class="fas fa-search"></i> Search</button> ?>


	</form>

	<div class="container hzCharityDetailContainer position-sticky" ng-show="charity">
		<div class="jumbotron">
			<h2 class="display-6">{{charity.CharityName}}</h2>
			<p>{{charity.CharitableObjects}}</p>

			<div class="alert alert-danger" role="alert" ng-show="!charityRegistered">
				This charity was registered on {{charity.RegistrationHistory.RegistrationDate|date:'dd MMM yyyy'}}, It was removed from the register on {{charity.RegistrationHistory.RegistrationRemovalDate|date:'dd MMM yyyy'}}. Reason for removal: {{charity.RegistrationHistory.RemovalReason}}.

			</div>

			<div class="row" ng-show="charityRegistered">
				<div class="col-sm-4">
					<p ng-show="charity.CharityNumber"><strong>Charity no. {{charity.CharityNumber}}</strong>
					</p>
					<p ng-show="charity.RegisteredCompanyNumber"><strong>Company no. {{charity.RegisteredCompanyNumber}}</strong>
					</p>
				</div>
				<div class="col-sm-4" ng-show="charity.PublicTelephoneNumber"><strong>Contact details</strong>
					<p>{{charity.PublicTelephoneNumber}}</p>
				</div>
				<div class="col-sm-4"><strong>Public address</strong>
					<p><span ng-repeat="line in charity.Address">{{line}}{{$last ? '' : ', '}}</span>
					</p>
				</div>
			</div>

			<div class="row" ng-show="charity.Activities">
				<div class="col-sm-12">
					<div class="alert alert-primary" role="alert">
						<strong>Aims &amp; activities</strong>
						<p>{{charity.Activities}}</p>
					</div>
				</div>
			</div>
			<div class="row" ng-show="charityRegistered">
				<div class="col-sm-4" ng-show="charity.Classification.What">
					<hr class="my-4">
					<p><strong>What the charity does</strong>
					</p>
					<p><span ng-if="isArray(charity.Classification.What)" ng-repeat="line in charity.Classification.What">{{line}}<br></span>
						<span ng-if="!isArray(charity.Classification.What)">{{charity.Classification.What}}<br></span>
					</p>
				</div>
				<div class="col-sm-4" ng-show="charity.Classification.Who">
					<hr class="my-4">
					<p><strong>Who the charity helps</strong>
					</p>
					<p><span ng-if="isArray(charity.Classification.Who)" ng-repeat="line in charity.Classification.Who">{{line}}<br></span>
						<span ng-if="!isArray(charity.Classification.Who)">{{charity.Classification.Who}}<br></span>
					</p>
				</div>
				<div class="col-sm-4" ng-show="charity.Classification.How">
					<hr class="my-4">
					<p><strong>How the charity works</strong>
					</p>
					<p><span ng-if="isArray(charity.Classification.How)" ng-repeat="line in charity.Classification.How">{{line}}<br></span>
						<span ng-if="!isArray(charity.Classification.How)">{{charity.Classification.How}}<br></span>
					</p>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12 text-right"><button type="button" class="btn btn-primary btn-sm" ng-click="closeCharity()"><i class="fas fa-times-circle"></i> Close Detail</button>
				</div>
			</div>
		</div>



	</div>
	<div class="container hzResultContainer" ng-show="!charity">
		<div class="hzLoader" ng-hide="!inprocess">
			<div class="hzLoaderAni"></div>
		</div>

		<div ng-show="errorMessage" class="alert alert-warning" role="alert">
			{{errorMessage}}
		</div>
<div class="table-responsive">
		<table class="table table-striped" ng-if="charities.length > 0">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Charity Name</th>
					<th scope="col">Status</th>
					<th scope="col"></th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="charity in charities">
					<th scope="row">{{charity.RegisteredCharityNumber}}</th>
					<td>{{charity.CharityName}}</td>
					<td>{{charity.RegistrationStatus}}</td>
					<td><button type="button" class="btn btn-primary btn-sm" ng-click="viewCharity(charity.RegisteredCharityNumber)">view</button>
					</td>
				</tr>
			</tbody>
		</table>
		</div>
	</div>
</div>
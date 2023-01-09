<main class="content">
	<!-- Header -->
	<div class="page-header">
		<h1 class="page-title">User Management | <small>Client</small>
		</h1>
		<button type="button" class="btn icon-btn align-self-start" data-toggle="slide" data-target="#projectInfo">
			<span class="material-icons-outlined">info</span>
		</button>
	</div>
	<nav class="nav-tab-container border-bottom">
		<ul class="nav-tab">
			<li class="nav-tab-item active">
				<button class="link-btn" data-toggle="custom-tab" data-target="#userProfile">User Profile</button>
			</li>
			<li class="nav-tab-item">
				<button class="link-btn" data-toggle="custom-tab" data-target="#userLogHistory">Log History</button>
			</li>
			<li class="nav-tab-item">
				<button class="link-btn" data-toggle="custom-tab" data-target="#userProject">Joined Project/s</button>
			</li>
		</ul>
	</nav>
	<hr>
	<div class="custom-tab-container">
		<div id="userProfile" class="main-content custom-tab-content show">
			<div class="container">
				<div class="samp">
					<div class="innerleft">
						<img src="../../images/ic0n.jpg" class="user-img" style="padding-left: 10px;">
						<h5>Kathiana Fernandez</h5>
					</div>
					<div class="vertical">
						<div class="innerright">
							<div class="user-info">
								<p>
								<p>
									<strong>Username: </strong> lancaster
								</p>
								<p>
									<strong>Email Address: </strong>>el@emailcom
								</p>
								<p>
									<strong>Password: </strong>tae
								</p>
								<p>
									<strong>Position: </strong>admin
								</p>
								<p>
									<strong>Address: </strong> lancaster
								</p>
								<p>
									<strong>Contact No.: </strong>031245624
								</p>
								<p>
									<strong>Birthdate: </strong>10/10/10
								</p>
								</p>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<h5>Actions</h5>
				<div class="buttons">
					<button type="button" class="btn primary-btn slim-btn " data-toggle="popup" data-target="#resetPass"> Reset Password </button>
					<button type="button" class="btn primary-btn slim-btn danger-btn " data-toggle="popup" data-target="#deleteAcc"> Delete Account </button>
				</div>
				<!-- Reset Pass Popup -->
				<div class="popup popup-center" id="resetPass" tabindex="-1" aria-hidden="true">
					<div class="pcontainer">
						<div class="pcontent">
							<div class="pheader">
								<!-- Can add icon here -->
								<i class="fa-sharp fa-solid fa-lock"></i>
								<h2 class="ptitle">Reset Password</h2>
								<button type="button" class="icon-btn close-btn" data-dismiss="popup" aria-label="Close">
									<span class="material-icons">close</span>
								</button>
							</div>
							<div class="pbody">
								<div class="form-group">
									<label>New Password:</label>
									<input type="text" name="name" class="form-control" value="">
									<label>Re-type Password:</label>
									<input type="text" name="name" class="form-control" value="">
								</div>
							</div>
							<div class="pfooter">
								<button type="button" class="btn action-btn">Reset</button>
								<button type="button" class="btn link-btn" data-dismiss="popup">Cancel</button>
							</div>
						</div>
					</div>
				</div>
				<!-- delete acc Popup -->
				<div class="popup popup-center popup-delete" id="deleteAcc" tabindex="-1" aria-hidden="true">
					<div class="pcontainer popup-sm">
						<div class="pcontent">
							<div class="pheader">
								<!-- Can add icon here -->
								<h2 class="ptitle">Delete Account</h2>
								<button type="button" class="icon-btn close-btn" data-dismiss="popup" aria-label="Close">
									<span class="material-icons">close</span>
								</button>
							</div>
							<div class="pbody">
								<p>Are you sure you want to delete this account?</p>
							</div>
							<div class="pfooter">
								<button type="button" class="btn danger-btn">Delete</button>
								<button type="button" class="btn link-btn" data-dismiss="popup">Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="userLogHistory" class="main-content custom-tab-content">
			<div class="container">
				<!-- USER LOG HISTORY -->
				<div class="mesa-container">
					<table class="mesa">
						<thead class="mesa-head">
							<tr>
								<th scope="col">#</th>
								<th scope="col">Activities</th>
								<th scope="col">Last Login Date/Time</th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th scope="row">1</th>
								<td>Check Ganttchart</td>
								<td>03/04/2022 | 11:58</td>
							</tr>
							<tr class="">
								<th scope="row">1</th>
								<td>Check Ganttchart</td>
								<td>03/04/2022 | 11:58</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div id="userProject" class="main-content custom-tab-content">
			<div class="container">
				<!-- USER JOINED PROJECT-->
				<div class="mesa-container">
					<table class="mesa">
						<thead class="mesa-head">
							<tr>
								<th scope="col">#</th>
								<th scope="col">Project Name/Description</th>
								<th scope="col">Address</th>
								<th scope="col">Date/Time</th>
								<th scope="col">Status</th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th scope="row">1</th>
								<td>Installation of LPG Pipeline</td>
								<td>Lancaster New City, Gentri, Cavite</td>
								<td>03/04/2022 | 11:58</td>
								<td>Ongoing</td>
								<td>
									<div class="dropdown ml-auto">
										<i class="fa-solid fa-ellipsis-vertical" data-toggle="dropdown" aria-expanded="false"></i>
										<div class="dropdown-menu dropdown-menu-lg-right">
											<button class="dropdown-item" type="button" data-toggle="popup" data-target="#removefromJoined" aria-expanded="false"> Remove </button>
										</div>
									</div>
								</td>
								<!-- remove from joined  Popup -->
								<div class="popup popup-center popup-delete" id="removefromJoined" tabindex="-1" aria-hidden="true">
									<div class="pcontainer popup-sm">
										<div class="pcontent">
											<div class="pheader">
												<!-- Can add icon here -->
												<h2 class="ptitle">Remove from Joined Project</h2>
												<button type="button" class="icon-btn close-btn" data-dismiss="popup" aria-label="Close">
													<span class="material-icons">close</span>
												</button>
											</div>
											<div class="pbody">
												<p>Are you sure you want to remove this user from joined project?</p>
											</div>
											<div class="pfooter">
												<button type="button" class="btn danger-btn">Remove</button>
												<button type="button" class="btn link-btn" data-dismiss="popup">Cancel</button>
											</div>
										</div>
									</div>
								</div>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</main>
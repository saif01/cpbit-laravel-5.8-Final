<!-- modal start -->
			<!-- Button trigger modal -->
			<div class="modal fade" id="userRegisterModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Registration Here</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form action="" method="post">

                                <div class="row">

                                    <div class="col">
                                        <label for="login_id">Login ID</label> <span class="ml-1"><i class="fa fa-asterisk text-danger"></i></span>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="Login ID"><i class="fa fa-lock"></i></span>
                                            </div>
                                            <input type="text" name="login_id" class="form-control" id="login_id" placeholder="Enter Your Login ID" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="user_name">User Name</label><i class="fa fa-asterisk" style="color: red;"></i>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="user_name"><i class="fa fa-user"></i></span>
                                            </div>
                                            <input type="text" name="user_name" class="form-control" id="user_name" placeholder="Enter User Name" required>
                                        </div>
                                    </div>

                                </div>


								<div class="col mt-3">
									<label for="bu_location">User BU(Location)</label><i class="fa fa-asterisk" style="color: red; font-size: 8px; margin-left: 1%"></i>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" id="bu_location"><i class="fa fa-map-marker-alt"></i></span>
										</div>
										<select class="form-control" name="bu_location" required="">
											<option value="">Select One</option>
											<option value="">Dhaka</option>
										</select>
									</div>
								</div>
								<div class="col mt-3">
									<label for="department">Department</label><i class="fa fa-asterisk" style="color: red; font-size: 8px; margin-left: 1%"></i>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" id="department"><i class="fa fa-map-marker-alt"></i></span>
										</div>
										<select class="form-control" name="department" required="">
											<option value="">Select One</option>
											<option value="">Dhaka</option>
										</select>
									</div>
								</div>
								<div class="col mt-3">
									<label for="email">User Email</label><i class="fa fa-asterisk" style="color: red; font-size: 8px; margin-left: 1%"></i>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" id="email"><i class="fa fa-envelope-open"></i></span>
										</div>
										<input type="email" name="email" class="form-control" id="email" placeholder="Enter User Email" required>
									</div>
								</div>
								<div class="col mt-3">
									<label for="buh_email">B.U. Head Email</label><i class="fa fa-asterisk" style="color: red; font-size: 08px; margin-left: 1%"></i>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" id="buh_email"><i class="fa fa-envelope-open"></i></span>
										</div>
										<input type="email" name="buh_email" class="form-control" id="buh_email" placeholder="Enter B.U. Head Email" required>
									</div>
								</div>
								<div class="col mt-3">
									<label for="ofice_id">Office ID</label><i class="fa fa-asterisk" style="color: red; font-size: 08px; margin-left: 1%"></i>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" id="ofice_id"><i class="fa fa-id-card"></i></span>
										</div>
										<input type="text" name="ofice_id" class="form-control" id="ofice_id" placeholder="Enter User Office ID" required>
									</div>
								</div>
								<div class="col mt-3">
									<label for="mobile_number">Mobile Number</label><i class="fa fa-asterisk" style="color: red; font-size: 08px; margin-left: 1%"></i>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" id="mobile_number"><i class="fa fa-mobile"></i></span>
										</div>
										<input type="number" name="mobile_number" class="form-control" id="ofice_id" placeholder="Enter User Mobile Numer" required>
									</div>
								</div>
								<div class="col mt-3">
									<label for="email">User  Photo</label><i class="fa fa-asterisk" style="color: red; font-size: 8px; margin-left: 1%"></i>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" id="email"><i class="fa fa-image"></i></span>
										</div>
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="validatedCustomFile" required>
											<label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;Sign UP</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<!-- end modal -->

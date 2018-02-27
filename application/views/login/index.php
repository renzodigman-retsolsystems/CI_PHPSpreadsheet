<center>
	<h1><?= $header; ?></h1>
	<div class="row">
		<div class="col offset-l4 l4 offset-m3 m6 s12">
			<div class="card grey lighten-5">
				<?php
					$attributes = array('id' => 'form_signin');
					echo form_open('userauth', $attributes);
				?>
					<div class="card-content">
						<?= $errorMsg; ?>
						<span class="card-title">Sign In</span>
						<div class="row">
							<div class="input-field col s10 offset-s1">
								<input id="user" name="user" type="text" class="validate">
								<label for="user">Username / Email</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s10 offset-s1">
								<input id="password" name="password" type="password" class="validate">
								<label for="password">Password</label>
							</div>
						</div>
						<span id="forgot-password" style="font-size:10px; cursor:hand;">Forgot Password?</span>
					</div>
					<div class="card-action">
						<button class="waves-effect waves-teal btn-flat indigo darken-5 white-text">Sign In</button>
						<div id="loading" class="preloader-wrapper small active" style="display:none;">
							<div class="spinner-layer spinner-green-only">
								<div class="circle-clipper left">
									<div class="circle"></div>
								</div><div class="gap-patch">
									<div class="circle"></div>
								</div>
								<div class="circle-clipper right">
									<div class="circle"></div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</center>

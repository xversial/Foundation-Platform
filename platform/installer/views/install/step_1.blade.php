@layout('installer::template')

@section('title')
{{ Lang::line('installer::general.title') }} | {{ Lang::line('installer::install.step_1.title') }}
@endsection

@section('navigation')
	<h1>{{ Lang::line('installer::install.step_1.title') }}</h1>
	<p class="step">{{ Lang::line('installer::install.step_1.tagline') }}</p>
	<div class="breadcrumbs">
		<ul class="nav">
			<li class="active"><span>{{ Lang::line('installer::install.step_1.step') }}</span> {{ Lang::line('installer::install.step_1.step_description') }}</li>
			<li><span>{{ Lang::line('installer::install.step_2.step') }}</span> {{ Lang::line('installer::install.step_2.step_description') }}</li>
			<li><span>{{ Lang::line('installer::install.step_3.step') }}</span> {{ Lang::line('installer::install.step_3.step_description') }}</li>
			<li><span>{{ Lang::line('installer::install.step_4.step') }}</span> {{ Lang::line('installer::install.step_4.step_description') }}</li>
		</ul>
	</div>
@endsection

@section('content')
<section id="checks">
	<header>
		<h2>{{ Lang::line('installer::install.step_1.description') }}</h2>
	</header>
	<hr>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">

				<div id="permissions">
					<div class="permissions" id="permissions-pass">
						<div data-template>
							<code class="alert alert-success">[%.%]</code>
						</div>
					</div>
					<div class="permissions" id="permissions-fail">
						<div data-template>
							<code class="alert alert-error">[%.%]</code>
						</div>
					</div>
				</div>

				<form id="filesystem-form" class="form-horizontal" method="POST" accept-char="UTF-8">
				<input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">


					<div class="navbar">
						<div class="navbar-inner">
							<a class="brand">Enable FTP (optional)</a>
							<div class="pull-right">
								<a class="btn" data-toggle="collapse" data-target="#ftp"><i class="icon-upload-alt"></i></a>
							</div>
						</div>
					</div>

					<div id="ftp" class="collapse out">

						<!-- FTP Credentials -->
						<fieldset>
							<legend>FTP Credentials</legend>

							<p class="summary">While using FTP is optional, it is highly recommended.  Using FTP for the filesystem will help prevent permission issues with creating and writing to directories and files.  If FTP fails it will fallback to the native PHP driver.</p>


							<!-- Enable FTP -->
							<div class="control-group">
								<div class="controls">
									<label class="checkbox">
									<input type="checkbox" name="ftp_enable" id="ftp_enable" value="1"> Enable FTP
									</label>
								</div>
							</div>

							<!-- Server -->
							<div class="control-group">
								<label class="control-label" for="ftp-server">Server</label>
								<div class="controls">
									<div class="input-append">
										<input type="text" name="ftp_server" id="ftp_server" placeholder="server">
										<span class="add-on"><i class="icon-hdd"></i></span>
									</div>
									<span class="help-block"></span>
								</div>
							</div>

							<!-- User -->
							<div class="control-group">
								<label class="control-label" for="ftp-user">User</label>
								<div class="controls">
									<div class="input-append">
										<input type="text" name="ftp_user" id="ftp_user" placeholder="user">
										<span class="add-on"><i class="icon-user"></i></span>
									</div>
									<span class="help-block"></span>
								</div>
							</div>

							<!-- Password -->
							<div class="control-group">
								<label class="control-label" for="ftp-password">Password</label>
								<div class="controls">
									<div class="input-append">
										<input type="password" name="ftp_password" id="ftp_password" placeholder="password">
										<span class="add-on"><i class="icon-lock"></i></span>
									</div>
									<span class="help-block"></span>
								</div>
							</div>

							<!-- Port -->
							<div class="control-group">
								<label class="control-label" for="ftp-port">Port</label>
								<div class="controls">
									<div class="input-append">
										<input type="text" name="ftp_port" id="ftp_port" value="21" placeholder="port">
										<span class="add-on"><i class="icon-cog"></i></span>
									</div>
									<span class="help-block"></span>
								</div>
							</div>

							<!-- Test FTP -->
							<div class="control-group">
								<label class="control-label">Test</label>
								<div class="controls">
									<a href="{{ URL::to('installer/install/ftp_test') }}" class="btn btn-medium" id="ftp-test">Connect</a>
									<div id="ftp-status" class="help-block"></div>
								</div>
							</div>

						</fieldset>

					</div>

					<!-- Form Actions -->
					<div class="form-actions">
						<div class="pull-right">
							<button type="submit" id="continue-btn" class="btn btn-large {{ (count($permissions['fail']) > 0) ? 'disabled' : null }}">
								{{ Lang::line('installer::button.next') }}
							</button>
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</section>
@endsection

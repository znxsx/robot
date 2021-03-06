@include('includes.head')
<body class="animated fadeIn auth-body" ng-app="base_app">
<section id="login-container">
	<img src="/assets/img/login-logo.png" alt="logo" class="auth-logo pull-right">
	<div class="">
		<div class="col-md-3" id="login-wrapper">
			<div class="row auth-title">
				<h1>Remebot医疗机器人</h1>
				<h2>运营管理系统</h2>
			</div>
			<div class="panel panel-primary animated flipInY">
				<div class="panel-heading">
					<h3 class="panel-title">
						请选择用户角色
					</h3>
				</div>
				<div class="panel-body" ng-cloak>
					<form ng-submit="c_form_auth.submit()"
						  name="formAuth"
						  novalidate
						  ng-controller="CFormAuth as c_form_auth"
						  class="form-horizontal"
						  role="form">
						<div class="form_container">
							<p class="error" ng-if="c_form_auth.login_fail && c_form_auth.auth_type == 'login'"
									>用户名或密码错误</p>
							<tabset justified="true">
								<tab heading="厂商" select="c_form_auth.on_tab_change('employee', 'login')">
									<div class="form-group">
										<div class="col-md-12">
											<input required
												   name="username"
												   ng-model="c_form_auth.vals.username"
												   ng-model-options="{debounce: 300}"
												   type="username"
												   class="form-control"
												   id="username"
												   placeholder="用户名">
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<input required
												   name="password"
												   ng-model="c_form_auth.vals.password"
												   ng-model-options="{debounce: 300}"
												   type="password"
												   class="form-control"
												   id="password"
												   placeholder="密码">
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12 text-right">
											<a href="" ng-click="c_form_auth.forget()">忘记密码</a>
											<button type="submit"
													class="btn btn-primary pull-right">登录
											</button>
										</div>
									</div>
								</tab>
								<tab heading="医院科室用户" select="c_form_auth.on_tab_change('department', 'login')">
									<div class="form-group">
										<div class="col-md-12">
											<input required
												   name="username"
												   ng-model="c_form_auth.vals.username"
												   ng-model-options="{debounce: 300}"
												   type="username"
												   class="form-control"
												   id="username"
												   placeholder="用户名">
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<input required
												   name="password"
												   ng-model="c_form_auth.vals.password"
												   ng-model-options="{debounce: 300}"
												   type="password"
												   class="form-control"
												   id="password"
												   placeholder="密码">
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12 text-right">
											<button type="submit" class="btn btn-primary pull-right">登录</button>
										</div>
									</div>
								</tab>
								<tab heading="代理商" select="c_form_auth.on_tab_change('agency', 'login')">
									<div class="form-group" ng-if="c_form_auth.auth_type == 'signup'">
										<div class="col-md-12">
											<a ng-click="c_form_auth.auth_type = 'login'"
											   href="">登录</a>
										</div>
									</div>
									<div class="login_fields">
										<div class="form-group">
											<div class="col-md-12">
												<input type="text"
													   name="username"
													   class="form-control"
													   placeholder="用户名"
													   ng-model="c_form_auth.vals.username"
													   ng-model-options="{debounce: 300}"
													   >

												<div class="error"
													 ng-if="formAuth.username.$error.laExist && formAuth.username.$touched &&c_form_auth.auth_type == 'signu' ">
													用户名已存在
												</div>
												<div class="error"
													 ng-if="formAuth.username.$invalid && formAuth.username.$touched && c_form_auth.auth_type == 'signup' "
														>用户名长度应在{{conf('v_rule.user_name.min_length')}}
													位至{{conf('v_rule.user_name.max_length')}}之间，由数字或字母组成
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-12">
												<input type="password"
													   name="password"
													   ng-model="c_form_auth.vals.password"
													   ng-model-options="{debounce: 300}"
													   class="form-control"
													   placeholder="密码"
													   id="password_field">

												<div class="error"
													 ng-if="formAuth.password.$invalid && formAuth.password.$touched && c_form_auth.auth_type == 'signup' "
														>密码长度应在{{conf('v_rule.password.min_length')}}
													位至{{conf('v_rule.password.max_length')}}之间，由数字或字母组成，至少包含一个字母
												</div>
												<span ng-if="c_form_auth.auth_type == 'signup'" la-toggle-input-type
													  la-target="password_field">按住看一眼</span>
											</div>
										</div>
									</div>
									<div ng-if="c_form_auth.auth_type == 'signup'"
										 class="signup_fields">
										<div class="form-group">
											<div class="col-md-12">
												<input required
													   name="name"
													   ng-model="c_form_auth.vals.name"
													   ng-model-options="{debounce: 300}"
													   type="text"
													   class="form-control"
													   id="name"
													   placeholder="公司名称">
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<select class="form-control"
														name="province_id"
														chosen
														ng-model="c_form_auth.vals.province_id"
														ng-model-options="{debounce: 300}"
														ng-options="l.id as l.name for l in SBase._.location.province"
														required>
													<option value="" selected>所在省份</option>
												</select>
												{{--<div class="" ng-repeat="l in SBase._.location.province"></div>--}}
											</div>
										
											<div class="col-md-6">
												<select class="form-control"
														chosen
														ng-model="c_form_auth.vals.city_id"
														update="c_form_auth.vals.province_id"
														ng-model-options="{debounce: 300}"
														ng-options="l.id as l.name for l in SBase._.location.city
													| filter: {parent_id: c_form_auth.vals.province_id} : true"
														name="province"
														required>
													<option value="" selected>所在市区</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-12">
												<input required
													   name="name_in_charge"
													   ng-model="c_form_auth.vals.name_in_charge"
													   ng-model-options="{debounce: 300}"
													   type="text"
													   class="form-control"
													   id="name_in_charge"
													   placeholder="负责人姓名">
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-12">
												<input required
													   name="phone"
													   ng-model="c_form_auth.vals.phone"
													   ng-model-options="{debounce: 300}"
													   type="text"
													   class="form-control"
													   id="phone"
													   placeholder="手机">
												<div class="error"
													 ng-if="formAuth.phone.$invalid && formAuth.phone.$touched">
													手机填写有误
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-12">
												<input required
													   type="email"
													   name="email"
													   ng-model="c_form_auth.vals.email"
													   ng-model-options="{debounce: 300}"
													   type="text"
													   class="form-control"
													   id="email"
													   placeholder="邮箱">
												<div class="error"
													 ng-if="formAuth.email.$invalid && formAuth.email.$touched">
													邮箱填写有误
												</div>

											</div>
										</div>
									</div>
									<div class="form-group" ng-if="c_form_auth.auth_type == 'login'">
										<div class="col-md-12 text-right">
											<button ng-click="c_form_auth.show_sign_up()"
											   href="" class="pull-left btn btn-default">我要注册</button>
											<a href="" ng-click="c_form_auth.forget()">忘记密码</a>
											<button type="submit"
													class="btn btn-primary pull-right">登录
											</button>
										</div>
									</div>
									<div class="form-group" ng-if="c_form_auth.auth_type == 'signup'">
									    <div class="col-md-8">
									        <input type="checkbox" name="agree" required ng-model="c_form_auth.vals.agree">  我已经阅读并同意<a href="" ng-click="c_form_auth.show_agreement()">《用户使用条款》</a>
									    </div>
										<div class="col-md-4">
											<button type="submit"
													ng-disabled="formAuth.$invalid"
													class="btn btn-primary pull-right">注册
											</button>
										</div>
									</div>
								</tab>
							</tabset>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/ng-template" id="templates/agreement.html">
<div class="panel panel-default">
	<div class="panel-heading">
	<h3 class="panel-title">用户使用条款</h3>
	</div>
			
	<div class="panel-body">
	<h2>特别提示</h2>	
	<p>
	北京柏惠维康科技有限公司（以下简称“柏惠维康”）在此特别提醒您（用户）在注册成为用户之前，请认真阅读本《用户协议》（以下简称“协议”），确保您充分理解本协议中各条款。请您审慎阅读并选择接受或不接受本协议。除非您接受本协议所有条款，否则您无权注册、登录或使用本协议所涉服务。您的注册、登录、使用等行为将视为对本协议的接受，并同意接受本协议各项条款的约束。本协议约定柏惠维康与用户之间关于Remebot医疗机器人运营管理系统（以下简称“系统”）的权利义务。“用户”是指注册、登录、使用本系统的代理商。
	</p>
	<p>
	本协议可由柏惠维康随时更新，更新后的协议条款一旦公布即代替原来的协议条款，恕不再另行通知。在柏惠维康修改协议条款后，如果用户不接受修改后的条款，请立即停止使用柏惠维康提供的系统，用户继续使用柏惠维康提供的系统将被视为接受修改后的协议。
	</p>

	<h3>一、用户个人隐私信息保护</h3>
	<p>
        1、用户在注册账号或使用本系统的过程中，可能需要填写或提交一些必要的信息，如法律法规、规章规范性文件（以下称“法律法规”）规定的需要填写的身份信息。如用户提交的信息不完整或不符合法律法规的规定，则用户可能无法使用本系统或在使用本系统的过程中受到限制。
    </p>
    <p>
        2、个人隐私信息是指涉及用户个人身份或个人隐私的信息，比如，用户真实姓名、身份证号、手机号码。非个人隐私信息是指用户对本系统的操作状态以及使用习惯等明确且客观反映在系统中的基本记录信息、个人隐私信息范围外的其它普通信息，以及用户同意公开的上述隐私信息。
    </p>
    <p>
        3、尊重用户个人隐私信息的私有性是柏惠维康的一贯制度，柏惠维康将采取技术措施和其他必要措施，确保用户个人隐私信息安全，防止在本系统中收集的用户个人隐私信息泄露、毁损或丢失。在发生前述情形或者柏惠维康发现存在发生前述情形的可能时，将及时采取补救措施。
    </p>
    <p>
        4、柏惠维康未经用户同意不向任何第三方公开、透露用户个人隐私信息。但以下特定情形除外：
    </p>
    <p>
        (1) 柏惠维康根据法律法规规定或有权机关的指示提供用户的个人隐私信息；
    </p>
    <p>
        (2) 由于用户将其用户密码告知他人或与他人共享注册帐户与密码，由此导致的任何个人信息的泄漏，或其他非因柏惠维康原因导致的个人隐私信息的泄露；
    </p>
    <p>
        (3) 用户自行向第三方公开其个人隐私信息；
    </p>
    <p>
        (4) 用户与柏惠维康及合作单位之间就用户个人隐私信息的使用公开达成约定，柏惠维康因此向合作单位公开用户个人隐私信息；
    </p>
    <p>
        (5) 任何由于黑客攻击、电脑病毒侵入及其他不可抗力事件导致用户个人隐私信息的泄露。
    </p>
    <p>
        5、用户同意柏惠维康可在以下事项中使用用户的个人隐私信息：
    </p>
    <p>
        (1) 柏惠维康向用户及时发送重要通知，如软件更新、本协议条款的变更；
    </p>
    <p>
        (2) 柏惠维康内部进行审计、数据分析和研究等，以改进柏惠维康的产品、系统和与用户之间的沟通；
    </p>
    <p>
        (3) 依本协议约定，柏惠维康管理、审查用户信息及进行处理措施；
    </p>
    <p>
        (4) 适用法律法规规定的其他事项。除上述事项外，如未取得用户事先同意，柏惠维康不会将用户个人隐私信息使用于任何其他用途。
    </p>
    <p>
        6、为了改善柏惠维康的技术和系统，向用户提供更好的系统体验，柏惠维康或可会自行收集使用或向第三方提供用户的非个人隐私信息。
    </p>
    <h3>二、内容规范</h3>
    <p>
        1、本条所述内容是指用户使用本系统过程中所制作、上载、复制、发布、传播的任何内容，包括但不限于账号名称、用户说明等注册信息及认证资料，或文字等发送、回复或自动回复消息和相关链接页面，以及其他使用账号或本系统所产生的内容。
    </p>
    <p>
        2、用户不得利用本系统制作、上载、复制、发布、传播如下法律、法规和政策禁止的内容：
    </p>
    <p>
        (1) 反对宪法所确定的基本原则的；
    </p>
    <p>
        (2) 危害国家安全，泄露国家秘密，颠覆国家政权，破坏国家统一的；
    </p>
    <p>
        (3) 损害国家荣誉和利益的；
    </p>
    <p>
        (4) 煽动民族仇恨、民族歧视，破坏民族团结的；
    </p>
    <p>
        (5) 破坏国家宗教政策，宣扬邪教和封建迷信的；
    </p>
    <p>
        (6) 散布谣言，扰乱社会秩序，破坏社会稳定的；
    </p>
    <p>(7) 散布淫秽、色情、赌博、暴力、凶杀、恐怖或者教唆犯罪的；</p>
    <p>(8) 侮辱或者诽谤他人，侵害他人合法权益的；</p>
    <p>(9) 不遵守法律法规底线、社会主义制度底线、国家利益底线、公民合法权益底线、社会公共秩序底线、道德风尚底线和信息真实性底线的“七条底线”要求的；</p>
    <p>(10) 含有法律、行政法规禁止的其他内容的信息。</p>
    <p>3、用户不得利用本系统制作、上载、复制、发布、传播如下干扰系统正常运营，以及侵犯其他用户或第三方合法权益的内容：</p>
    <p>(1) 含有任何性或性暗示的；</p>
    <p>(2) 含有辱骂、恐吓、威胁内容的；</p>
    <p>(3) 含有骚扰、垃圾广告、恶意信息、诱骗信息的；</p>
    <p>(4) 涉及他人隐私、个人信息或资料的；</p>
    <p>(5) 侵害他人名誉权、肖像权、知识产权、商业秘密等合法权利的；</p>
    <p>(6) 含有其他干扰本系统正常运营和侵犯其他用户或第三方合法权益内容的信息。</p>
    <h3>三、使用规则</h3>
    <p>1、用户在本系统中或通过本系统所传送、发布的任何内容并不反映或代表，也不得被视为反映或代表柏惠维康的观点、立场或政策，柏惠维康对此不承担任何责任。</p>
    <p>2、用户不得利用本系统进行如下行为：</p>
    <p>(1) 提交、发布虚假信息，或盗用他人资料，冒充、利用他人名义的；</p>
    <p>(2) 强制、诱导其他用户关注、点击链接页面或分享信息的；</p>
    <p>(3) 虚构事实、隐瞒真相以误导、欺骗他人的；</p>
    <p>(4) 利用技术手段批量建立虚假账号的；</p>
    <p>(5) 利用本系统从事任何违法犯罪活动的；</p>
    <p>(6) 制作、发布与以上行为相关的方法、工具，或对此类方法、工具进行运营或传播，无论这些行为是否为商业目的；</p>
    <p>(7) 其他违反法律法规规定、侵犯其他用户合法权益、干扰系统正常运营或柏惠维康未明示授权的行为。</p>
    <p>3、用户须对利用本系统传送信息的真实性、合法性、无害性、准确性、有效性等全权负责，与用户所传播的信息相关的任何法律责任由用户自行承担，与柏惠维康无关。如因此给柏惠维康或第三方造成损害的，用户应当依法予以赔偿。</p>
    <p>4、柏惠维康提供的系统中可能包括广告，用户同意在使用过程中显示柏惠维康和第三方供应商、合作伙伴提供的广告。除法律法规明确规定外，用户应自行对依该广告信息进行的交易负责，对用户因依该广告信息进行的交易或前述广告商提供的内容而遭受的损失或损害，柏惠维康不承担任何责任。</p>
    <h3>四、帐户管理</h3>
    <p>1、系统账号的所有权归柏惠维康所有，用户完成申请注册手续后，获得系统账号的使用权。柏惠维康因经营需要，有权回收用户的系统账号。</p>
    <p>2、用户可以更改、系统帐户上的个人资料、注册信息及传送内容等，但需注意，删除有关信息的同时也会删除用户储存在系统中的文字。用户需承担该风险。</p>
    <p>3、用户有责任妥善保管注册账号信息及账号密码的安全，因用户保管不善可能导致遭受盗号或密码失窃，责任由用户自行承担。用户需要对注册账号以及密码下的行为承担法律责任。用户同意在任何情况下不使用其他用户的账号或密码。在用户怀疑他人使用其账号或密码时，用户同意立即通知柏惠维康。</p>
    <p>4、用户应遵守本协议的各项条款，正确、适当地使用本系统，如因用户违反本协议中的任何条款，柏惠维康在通知用户后有权依据协议中断或终止对违约用户提供系统。同时，柏惠维康保留在任何时候收回账号、用户名的权利。</p>
    <h3>五、数据储存</h3>
    <p>1、柏惠维康不对用户在本系统中相关数据的删除或储存失败负责。</p>
    <p>2、如用户停止使用本系统或本系统终止，柏惠维康可以从系统上永久地删除用户的数据。本系统停止、终止后，柏惠维康没有义务向用户返还任何数据。</p>
    <h3>六、风险承担</h3>
    <p>1、用户理解并同意，因业务发展需要，柏惠维康保留单方面对本系统的全部或部分系统内容变更、暂停、终止或撤销的权利，用户需承担此风险。</p>
    <h3>七、知识产权声明</h3>
    <p>1、除本系统中涉及广告的知识产权由相应广告商享有外，柏惠维康在本系统中提供的内容（包括但不限于网页、文字、图片、图表等）的知识产权均归柏惠维康所有，但用户在使用本系统前对自己发布的内容已合法取得知识产权的除外。</p>
    <p>2、除另有特别声明外，柏惠维康提供本系统时所依托软件的著作权、专利权及其他知识产权均归柏惠维康所有。</p>
    <p>3、柏惠维康在本系统中所涉及的图形、文字或其组成，以及其他柏惠维康标志及产品、系统名称（以下统称“柏惠维康标识”），其著作权或商标权归柏惠维康所有。未经柏惠维康事先书面同意，用户不得将柏惠维康标识以任何方式展示或使用或作其他处理，也不得向他人表明用户有权展示、使用、或其他有权处理柏惠维康标识的行为。</p>
    <p>4、上述及其他任何柏惠维康或相关广告商依法拥有的知识产权均受到法律保护，未经柏惠维康或相关广告商书面许可，用户不得以任何形式进行使用或创造相关衍生作品。</p>
    <h3>八、法律责任</h3>
    <p>1、如果柏惠维康发现或收到他人举报或投诉用户违反本协议约定的，柏惠维康有权不经通知随时对相关内容，包括但不限于用户资料、用户记录、用户数据进行审查、删除，并视情节轻重对违规账号处以包括但不限于警告、账号封禁、设备封禁、功能封禁的处罚，且通知用户处理结果。</p>
    <p>2、用户理解并同意，柏惠维康有权依合理判断对违反有关法律法规或本协议规定的行为进行处罚，对违法违规的任何用户采取适当的法律行动，并依据法律法规保存有关信息向有关部门报告等，用户应承担由此而产生的一切法律责任。</p>
    <p>3、用户理解并同意，因用户违反本协议约定，导致或产生的任何第三方主张的任何索赔、要求或损失，包括合理的律师费，用户应当赔偿柏惠维康与合作公司、关联公司，并使之免受损害。</p>
    <h3>九、不可抗力及其他免责事由</h3>
    <p>1、用户理解并确认，在使用本系统的过程中，可能会遇到不可抗力等风险因素，使本系统发生中断。不可抗力是指不能预见、不能克服并不能避免且对一方或双方造成重大影响的客观事件，包括但不限于自然灾害如洪水、地震、瘟疫流行和风暴等以及社会事件如战争、动乱、政府行为等。出现上述情况时，柏惠维康将努力在第一时间与相关单位配合，及时进行修复，但是由此给用户或第三方造成的损失，柏惠维康及合作单位在法律允许的范围内免责。</p>
    <p>2、本系统同大多数管理系统一样，受包括但不限于用户原因、网络系统质量、社会环境等因素的差异影响，可能受到各种安全问题的侵扰，如他人利用用户的资料，造成现实生活中的骚扰；用户下载安装的其它软件或访问的其他网站中含有“特洛伊木马”等病毒，威胁到用户的计算机信息和数据的安全，继而影响本系统的正常使用等等。用户应加强信息安全及使用者资料的保护意识，要注意加强密码保护，以免遭致损失和骚扰。</p>
    <p>3、用户理解并确认，本系统存在因不可抗力、计算机病毒或黑客攻击、系统不稳定、用户所在位置、用户关机以及其他任何技术、互联网络、通信线路原因等造成的系统中断或不能满足用户要求的风险，因此导致的用户或第三方任何损失，柏惠维康不承担任何责任。</p>
    <p>4、用户理解并确认，在使用本系统过程中存在来自任何他人的包括误导性的、欺骗性的、威胁性的、诽谤性的、令人反感的或非法的信息，或侵犯他人权利的匿名或冒名的信息，以及伴随该等信息的行为，因此导致的用户或第三方的任何损失，柏惠维康不承担任何责任。</p>
    <p>5、用户理解并确认，柏惠维康需要定期或不定期地对系统或相关的设备进行检修或者维护，如因此类情况而造成系统在合理时间内的中断，柏惠维康无需为此承担任何责任，但柏惠维康应事先进行通告。</p>
    <p>6、柏惠维康依据法律法规、本协议约定获得处理违法违规或违约内容的权利，该权利不构成柏惠维康的义务或承诺，柏惠维康不能保证及时发现违法违规或违约行为或进行相应处理。</p>
    <p>7、用户理解并确认，对于柏惠维康向用户提供的下列产品或者系统的质量缺陷及其引发的任何损失，柏惠维康无需承担任何责任：</p>
    <p>(1) 柏惠维康向用户免费提供的系统；</p>
    <p>(2) 柏惠维康向用户赠送的任何产品或者系统。</p>
    <p>8、在任何情况下，柏惠维康均不对任何间接性、后果性、惩罚性、偶然性、特殊性或刑罚性的损害，包括因用户使用本系统而遭受的利润损失，承担责任（即使柏惠维康已被告知该等损失的可能性亦然）。尽管本协议中可能含有相悖的规定，柏惠维康对用户承担的全部责任，无论因何原因或何种行为方式，始终不超过用户因使用柏惠维康提供的系统而支付给柏惠维康的费用(如有)。</p>
    <h3>十、其他</h3>
    <p>1、柏惠维康郑重提醒用户注意本协议中免除柏惠维康责任和限制用户权利的条款，请用户仔细阅读，自主考虑风险。</p>
    <p>2、本协议的效力、解释及纠纷的解决，适用于中华人民共和国法律。若用户和柏惠维康之间发生任何纠纷或争议，首先应友好协商解决，协商不成的，用户同意将纠纷或争议提交柏惠维康住所地有管辖权的人民法院管辖。</p>
    <p>3、本协议的任何条款无论因何种原因无效或不具可执行性，其余条款仍有效，对双方具有约束力。</p>
	</div>
</div>
</script>
@include('includes.foot')

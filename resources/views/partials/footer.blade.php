</div></div>

<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-5 platform-links">
                <ul class="footer-links">
                    <li><a href="{{ route('terms_of_service') }}">Terms</a></li>
                    <li><a href="{{ route('privacy_policy') }}">Privacy</a></li>
                    <li><a href="{{ route('security_policy') }}">Security</a></li>
                    <li><a href="{{ route('saying_thanks') }}">Thanks</a></li>
                    <li><a href="mailto:team@styleci.io">Contact</a></li>
                </ul>
            </div>
            <div class="col-sm-2 logo">
                <a href="{{ route('home') }}"><img src="{{ asset('img/footer-logo.png') }}" height="28" /></a>
            </div>
            <div class="col-sm-5 social-links">
                <ul class="footer-links">
                    <li><a href="https://status.styleci.io" target="_blank">Status</a></li>
                    <li><a href="https://blog.styleci.io" target="_blank">Blog</a></li>
                    <li><a href="{{ route('donate') }}">Donate</a></li>
                    <li><a href="https://twitter.com/teamstyleci" target="_blank">Twitter</a></li>
                    <li><a href="https://github.com/StyleCI" target="_blank">GitHub</a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 copyright">
                &copy; {{ date('Y') }} StyleCI
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ elixir('dist/js/app.js') }}"></script>
@section('js')
@show
@if (Config::get('analytics.enabled'))
    @include('partials.analytics')
@endif

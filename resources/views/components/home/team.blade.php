@props(['members'])
@if (count($members))
    <div class="flex flex-wrap mb-10 -mx-5 mobile:mb-5 our-team">
        @foreach ($members as $member)
            <div class="w-1/3 px-5 mb-6 mobile:w-full mobile:text-center">
                <div class="our-team-inner">
                    @if ($member->url('photo'))
                        <img src="{{ $member->url('photo') }}" alt="{{ $member->text('name') }}">
                    @endif
                    <h6>{{ $member->text('name') }}</h6>
                    <p>{{ $member->text('role') }}</p>
                    @if ($member->text('email'))
                        <ul>
                            <li>
                                <a href="mailto:{{ $member->text('email') }}" aria-label="{{ $member->text('email') }}">
                                    <img src="{{ asset('images/blue-mail-icon.svg') }}" alt="">
                                </a>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endif

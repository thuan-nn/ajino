<div class="popup__home home__popup {{ $popup['is_published'] ? 'is-display' : '' }}">
    <div class="home__popup-wrap" style="background-image: url('{{ getImageSetting($popup) }}')">
        <a href="{{ isset($popup['url']) ? $popup['url'][$locale] : '' }}" target="_blank" class="home__popup-navigation">
            <div class="home__popup-header">
                <button href="javascript:void(0)" class="home__popup-close"></button>
            </div>
        </a>
    </div>
</div>
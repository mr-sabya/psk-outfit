<div class="coupon-container">
    <div class="row g-3">
        @forelse($coupons as $coupon)
        @php
        $isPrivate = Auth::check() && $coupon->users->contains(Auth::id());
        @endphp
        <div class="col-md-6">
            <div class="coupon-card {{ $isPrivate ? 'is-exclusive' : '' }}">
                <!-- Left Section: The Value -->
                <div class="coupon-badge">
                    <div class="value">
                        {{ $coupon->type->value == 'percentage' ? (int)$coupon->value : '৳' . (int)$coupon->value }}<span>{{ $coupon->type->value == 'percentage' ? '%' : '' }}</span>
                    </div>
                    <div class="label">OFF</div>
                </div>

                <!-- Separator Line with Cutouts -->
                <div class="coupon-separator">
                    <div class="cutout top"></div>
                    <div class="dot-line"></div>
                    <div class="cutout bottom"></div>
                </div>

                <!-- Right Section: Details -->
                <div class="coupon-info">
                    @if($isPrivate)
                    <span class="exclusive-tag">Exclusive for you</span>
                    @endif
                    <h5 class="coupon-code">{{ $coupon->code }}</h5>
                    <p class="coupon-desc">{{ Str::limit($coupon->description ?? 'Valid on all items', 40) }}</p>

                    <div class="coupon-footer">
                        <span class="expiry"><i class="far fa-clock"></i> Exp: {{ $coupon->valid_until ? $coupon->valid_until->format('d M') : 'N/A' }}</span>

                        <div x-data="{ 
                                copied: false, 
                                copyToClipboard(text) {
                                    navigator.clipboard.writeText(text);
                                    this.copied = true;
                                    setTimeout(() => this.copied = false, 2000);
                                } 
                            }">
                            <button @click="copyToClipboard('{{ $coupon->code }}')"
                                class="copy-btn"
                                :class="copied ? 'copied' : ''">
                                <span x-show="!copied">COPY</span>
                                <span x-show="copied"><i class="fas fa-check"></i></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-4 w-100">
            <img src="https://cdn-icons-png.flaticon.com/512/4072/4072217.png" width="60" class="opacity-25 mb-2">
            <p class="text-muted small">No active offers currently available.</p>
        </div>
        @endforelse
    </div>
</div>
<svg {{ $attributes->merge(['class' => 'h-10 w-10']) }} viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
    <defs>
        <linearGradient id="salonGradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#E91E63;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#CE93D8;stop-opacity:1" />
        </linearGradient>
    </defs>
    <g fill="url(#salonGradient)">
        <!-- Tesoura estilizada -->
        <circle cx="30" cy="25" r="8" />
        <ellipse cx="30" cy="40" rx="3" ry="20" />
        <path d="M 28 60 Q 30 70, 50 85" stroke="url(#salonGradient)" stroke-width="3" fill="none"
            stroke-linecap="round" />
        <circle cx="70" cy="25" r="8" />
        <ellipse cx="70" cy="40" rx="3" ry="20" />
        <path d="M 72 60 Q 70 70, 50 85" stroke="url(#salonGradient)" stroke-width="3" fill="none"
            stroke-linecap="round" />
        <circle cx="50" cy="87" r="5" fill="#FFD700" />
    </g>
</svg>

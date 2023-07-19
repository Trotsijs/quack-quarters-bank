<div x-data="{ show: true }"
     x-show="show"
     x-init="setTimeout(() => show = false, 5000)"
     @click.away="show = false"
     id="success-notification"
     class="bg-red-500 text-white px-4 py-1 shadow-md fixed top-16 inset-x-0 mx-0 mb-4 text-center">
    {{ $slot }}
</div>

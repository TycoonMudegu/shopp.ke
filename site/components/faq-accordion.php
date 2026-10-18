<div class="border-b border-gray-200">
    <button class="w-full text-left py-4 flex justify-between items-center focus:outline-none group" onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('svg').classList.toggle('rotate-180')">
        <span class="text-lg font-medium text-brandDark group-hover:text-brandGreen p-2"><?= htmlspecialchars($question) ?></span>
        <svg class="w-5 h-5 text-gray-500 transition-transform duration-300 transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
    </button>
    <div class="hidden pb-4 text-gray-600 px-2 leading-relaxed">
        <?= $answer ?>
    </div>
</div>

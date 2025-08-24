<button id="theme-toggle" class="w-full text-left">
    🌗 Đổi giao diện
</button>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('theme-toggle');
    const bodyTag = document.body; // ✅ dùng body thay vì html

    if (!toggleBtn) return;

    const savedTheme = localStorage.getItem('theme');

    // Áp dụng theme từ localStorage, mặc định là sáng
    if (savedTheme === 'dark') {
        bodyTag.classList.add('dark');
    } else {
        bodyTag.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    }

    // Khi bấm nút đổi giao diện
    toggleBtn.addEventListener('click', function () {
        const isDark = bodyTag.classList.contains('dark');
        if (isDark) {
            bodyTag.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        } else {
            bodyTag.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        }
    });
}); 
</script>

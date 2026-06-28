
// تأكيد الحذف
document.addEventListener('DOMContentLoaded', function() {
    // جميع روابط الحذف
    const deleteLinks = document.querySelectorAll('a[onclick*="confirm"]');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if(!confirm('هل أنت متأكد من عملية الحذف؟')) {
                e.preventDefault();
            }
        });
    });
    
    // معاينة الصورة قبل الرفع
    const imageInput = document.querySelector('input[type="file"][name="image"]');
    if(imageInput) {
        imageInput.addEventListener('change', function(e) {
            const preview = document.getElementById('image-preview');
            if(preview) {
                const file = e.target.files[0];
                if(file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
    }
});

// تحقق فوري من تطابق كلمة المرور
const password = document.querySelector('input[name="password"]');
const confirmPassword = document.querySelector('input[name="confirm_password"]');
if(password && confirmPassword) {
    confirmPassword.addEventListener('input', function() {
        if(this.value !== password.value) {
            this.style.borderColor = 'red';
            this.setCustomValidity('كلمة المرور غير متطابقة');
        } else {
            this.style.borderColor = 'green';
            this.setCustomValidity('');
        }
    });
}

// عرض الوقت والتاريخ
function updateDateTime() {
    const now = new Date();
    const datetime = document.getElementById('datetime');
    if(datetime) {
        datetime.textContent = now.toLocaleString('ar-EG');
    }
}
setInterval(updateDateTime, 1000);
updateDateTime();


---
paths:
  - 'resources/js**'
---

# Resources

## Toast errors sentral di http.js interceptor
http.js (axios interceptor) sudah menampilkan toast sendiri (panggil toast.error/warning dari lib/toast.js, bukan dispatch event 'toast:error' — event itu tidak punya listener). Karena interceptor selalu menampilkan toast untuk request gagal, modul pemanggil JANGAN memanggil toast.error lagi di catch (hindari dobel toast); cukup modal.showErrors(error.errors) bila ada field error.

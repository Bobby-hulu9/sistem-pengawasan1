// Contoh data lengkap dengan semua kolom sesuai permintaan
const regionalData = [
  {
    nik: "1234567890",
    name: "User 1",
    role: "Manager",
    am_type: "Type A",
    division: "Division 1",
    segment: "Segment 1",
    regional: "ACEH",
    witel: "Witel 1",
    ca_name: "CA Name 1",
    nipnas: "NIP001",
    id: 1,
    activity_start_date: "2024-01-10",
    activity_end_date: "2024-01-15",
    createdat: "2024-01-01",
    label: "Label 1",
    activity_type: "Audit",
    activity_notes: "Notes 1",
    photo_link: "photo1.jpg",
    nama_pic_1: "PIC 1",
    jabatan_pic_1: "Jabatan 1",
    peran_pic_1: "Peran 1",
    no_email_pic_1: "pic1@example.com",
    no_hp_pic_1: "081234567890",
    nama_pic_2: "PIC 2",
    jabatan_pic_2: "Jabatan 2",
    peran_pic_2: "Peran 2",
    no_email_pic_2: "pic2@example.com",
    no_hp_pic_2: "081234567891",
    nama_pic_3: "PIC 3",
    jabatan_pic_3: "Jabatan 3",
    peran_pic_3: "Peran 3",
    no_email_pic_3: "pic3@example.com",
    no_hp_pic_3: "081234567892"
  },
  {
    nik: "0987654321",
    name: "User 2",
    role: "Supervisor",
    am_type: "Type B",
    division: "Division 2",
    segment: "Segment 2",
    regional: "SUMUT",
    witel: "Witel 2",
    ca_name: "CA Name 2",
    nipnas: "NIP002",
    id: 2,
    activity_start_date: "2024-02-10",
    activity_end_date: "2024-02-20",
    createdat: "2024-02-01",
    label: "Label 2",
    activity_type: "Inspeksi",
    activity_notes: "Notes 2",
    photo_link: "photo2.jpg",
    nama_pic_1: "PIC A",
    jabatan_pic_1: "Jabatan A",
    peran_pic_1: "Peran A",
    no_email_pic_1: "pica@example.com",
    no_hp_pic_1: "081234567893",
    nama_pic_2: "PIC B",
    jabatan_pic_2: "Jabatan B",
    peran_pic_2: "Peran B",
    no_email_pic_2: "picb@example.com",
    no_hp_pic_2: "081234567894",
    nama_pic_3: "PIC C",
    jabatan_pic_3: "Jabatan C",
    peran_pic_3: "Peran C",
    no_email_pic_3: "picc@example.com",
    no_hp_pic_3: "081234567895"
  }
];

// Simpan data ke localStorage
localStorage.setItem('regionalData', JSON.stringify(regionalData));

// Fungsi untuk mengambil data dari localStorage
function getRegionalData() {
  const data = localStorage.getItem('regionalData');
  return data ? JSON.parse(data) : [];
}

// Contoh penggunaan: tampilkan data di console
console.log(getRegionalData());

CREATE TABLE `daotao` (
  `ma_dt` int(11) NOT NULL,
  `magv` int(11) NOT NULL,
  `malop` int(11) NOT NULL,
  `mamon` int(11) NOT NULL,
  `namhoc` int(11) NOT NULL,
  `hocki` int(11) NOT NULL,
  `lock_diem` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `diem` (
  `madiem` int(11) NOT NULL,
  `masv` int(11) NOT NULL,
  `mamon` int(11) NOT NULL,
  `diem1` decimal(10,2) NOT NULL,
  `diem2` decimal(10,2) NOT NULL,
  `diemthi` decimal(10,2) NOT NULL,
  `diemtbm` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `giang_vien` (
  `magv` int(11) NOT NULL,
  `hoten` varchar(255) NOT NULL,
  `gioitinh` varchar(50) NOT NULL,
  `ngaysinh` date NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `khoa_hoc` (
  `id_khoa` int(11) NOT NULL,
  `namhoc` year(4) NOT NULL,
  `namhet` year(4) NOT NULL,
  `kihieu_k` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `lop` (
  `malop` int(11) NOT NULL,
  `ma_nh` varchar(255) NOT NULL,
  `id_khoa` int(11) NOT NULL,
  `tenlop` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `monhoc` (
  `mamon` int(11) NOT NULL,
  `tenmon` varchar(255) NOT NULL,
  `sotinchi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `nganh_hoc` (
  `ma_nh` int(11) NOT NULL,
  `ten_nganh` varchar(255) NOT NULL,
  `kihieu_n` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `phuc_khao` (
  `ma_pk` int(11) NOT NULL,
  `masv` int(11) NOT NULL,
  `mamon` int(11) NOT NULL,
  `trang_thai` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `sinh_vien` (
  `masv` int(11) NOT NULL,
  `hoten` varchar(255) DEFAULT NULL,
  `gioitinh` varchar(255) NOT NULL,
  `Ngaysinh` date DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `ma_nh` varchar(255) DEFAULT NULL,
  `id_khoa` varchar(255) NOT NULL,
  `malop` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `user` (
  `maus` int(11) NOT NULL,
  `taikhoan` int(11) NOT NULL,
  `mat_khau` varchar(50) NOT NULL,
  `chucvu` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `daotao`
  ADD PRIMARY KEY (`ma_dt`);

--
-- Chỉ mục cho bảng `diem`
--
ALTER TABLE `diem`
  ADD PRIMARY KEY (`madiem`);

--
-- Chỉ mục cho bảng `giang_vien`
--
ALTER TABLE `giang_vien`
  ADD PRIMARY KEY (`magv`);

--
-- Chỉ mục cho bảng `khoa_hoc`
--
ALTER TABLE `khoa_hoc`
  ADD PRIMARY KEY (`id_khoa`);

--
-- Chỉ mục cho bảng `lop`
--
ALTER TABLE `lop`
  ADD PRIMARY KEY (`malop`);

--
-- Chỉ mục cho bảng `monhoc`
--
ALTER TABLE `monhoc`
  ADD PRIMARY KEY (`mamon`);

--
-- Chỉ mục cho bảng `nganh_hoc`
--
ALTER TABLE `nganh_hoc`
  ADD PRIMARY KEY (`ma_nh`);

--
-- Chỉ mục cho bảng `phuc_khao`
--
ALTER TABLE `phuc_khao`
  ADD PRIMARY KEY (`ma_pk`);

--
-- Chỉ mục cho bảng `sinh_vien`
--
ALTER TABLE `sinh_vien`
  ADD PRIMARY KEY (`masv`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`maus`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `daotao`
--
ALTER TABLE `daotao`
  MODIFY `ma_dt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `diem`
--
ALTER TABLE `diem`
  MODIFY `madiem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT cho bảng `giang_vien`
--
ALTER TABLE `giang_vien`
  MODIFY `magv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `khoa_hoc`
--
ALTER TABLE `khoa_hoc`
  MODIFY `id_khoa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5111108;

--
-- AUTO_INCREMENT cho bảng `lop`
--
ALTER TABLE `lop`
  MODIFY `malop` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90015;

--
-- AUTO_INCREMENT cho bảng `monhoc`
--
ALTER TABLE `monhoc`
  MODIFY `mamon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `nganh_hoc`
--
ALTER TABLE `nganh_hoc`
  MODIFY `ma_nh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2008;

--
-- AUTO_INCREMENT cho bảng `phuc_khao`
--
ALTER TABLE `phuc_khao`
  MODIFY `ma_pk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `sinh_vien`
--
ALTER TABLE `sinh_vien`
  MODIFY `masv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21111055;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `maus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
COMMIT;
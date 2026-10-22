-- Run once in phpMyAdmin for an existing Nasaq database.
-- Safe to re-run: preserves existing content and settings.
CREATE TABLE IF NOT EXISTS site_settings (
  setting_key VARCHAR(64) NOT NULL PRIMARY KEY,
  setting_value TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT IGNORE INTO site_settings(setting_key,setting_value) VALUES
('site_name','نَسَق'),('site_tagline','أعمالك بنسق مختلف'),
('site_description','منصة الأعمال والحلول الرقمية'),
('hero_title','أفكار طموحة. تنفيذ بنسق مختلف.'),
('hero_description','منصة تجمع تطوير البرمجيات والحلول التقنية والمنتجات الرقمية في تجربة واحدة.'),
('contact_email',''),('contact_phone','');
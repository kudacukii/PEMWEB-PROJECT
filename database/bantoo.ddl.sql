drop view  if exists campaign_progress;
drop view  if exists campaigns;
drop view  if exists all_campaigns;
drop view  if exists active_campaigns;
drop view  if exists rejected_campaigns;
drop view  if exists completed_campaigns;
drop view  if exists reviewed_campaigns;
drop view  if exists active_campaigns_progress;
drop table if exists campaign_photos;
drop table if exists campaign_donation;
drop table if exists campaign_impression;
drop table if exists campaign;
-- drop table if exists donatur;
-- drop table if exists admin;
drop table if exists user;
drop table if exists photo;

CREATE TABLE user (
  id         int(11)      NOT NULL AUTO_INCREMENT,
  name       varchar(255) NOT NULL,
  email      varchar(255) NOT NULL,
  password   varchar(255) NOT NULL,
  photo      mediumblob   NULL,
  photo_type tinytext     NOT NULL DEFAULT 'image/jpeg',
  role       tinytext     NOT NULL DEFAULT 'USERS',
  created_at timestamp    NOT NULL DEFAULT current_timestamp()
  PRIMARY KEY (email),
  UNIQUE  KEY (id)
)
;

CREATE TABLE photo (
  id            int(11)   NOT NULL AUTO_INCREMENT,
  photo        longblob   NOT NULL,
  content_type tinytext   NOT NULL DEFAULT 'image/jpeg',
  created_at    timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id),
}
;

-- CREATE TABLE photo (
--   id           int(11)   NOT NULL AUTO_INCREMENT,
--   photo        longblob  NOT NULL,
--   type         text(1)   NOT NULL DEFAULT 'C',
--   content_type text(10)  NOT NULL DEFAULT 'image/jpeg',
--   created_at   timestamp NOT NULL DEFAULT current_timestamp(),
--   PRIMARY KEY (id),
--   UNIQUE  KEY (type),
--   CONSTRAINT  photo_type CHECK (type IN ('U', 'C')),
-- )
-- ;

-- CREATE TABLE admin (
--   id         int(11)      NOT NULL AUTO_INCREMENT,
--   email      varchar(255) NOT NULL,
--   password   varchar(255) NOT NULL,
--   name       varchar(255) NOT NULL,
--   photo_id   int(11) NULL,
--   created_at timestamp    NOT NULL DEFAULT current_timestamp(),
--   PRIMARY KEY email (email),
--   UNIQUE KEY (id)
--   CONSTRAINT  fk_admin_photo FOREIGN KEY (photo_id) REFERENCES photo(id) ON DELETE RESTRICT ON UPDATE RESTRICT
-- )
-- ;

-- CREATE TABLE donatur (
--   id         int(11)      NOT NULL AUTO_INCREMENT,
--   email      varchar(255) NOT NULL,
--   password   varchar(255) NOT NULL,
--   name       varchar(255) NOT NULL,
--   photo_id   int(11) NULL,
--   created_at timestamp    NOT NULL DEFAULT current_timestamp(),
--   PRIMARY KEY email (email),
--   UNIQUE KEY (id)
--   CONSTRAINT  fk_donatur_photo FOREIGN KEY (photo_id) REFERENCES photo(id) ON DELETE RESTRICT ON UPDATE RESTRICT
-- )
-- ;

CREATE TABLE campaign (
  id            int(11)       NOT NULL AUTO_INCREMENT,
  title         varchar(255)  NOT NULL,
  description   varchar(1024) NOT NULL,
  target_donasi decimal(15,2) NOT NULL DEFAULT 2,
  min_donasi    decimal(15,2) NOT NULL DEFAULT 1,
  max_donasi    decimal(15,2) NOT NULL DEFAULT 1,
  status        text(10)      NOT NULL DEFAULT 'PENDING',
  created_at    timestamp     NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id),
  CONSTRAINT   campaign_status_type  CHECK (status IN ('PENDING', 'ONGOING', 'REJECTED', 'COMPLETED')),
  CONSTRAINT   campaign_min_donation CHECK (min_donasi > 0),
  CONSTRAINT   campaign_max_donation CHECK (max_donasi >= min_donasi AND max_donasi < target_donasi)
)
;

CREATE TABLE campaign_donation (
  campaign_id int(11)       NOT NULL,
  donatur_id  int(11)       NOT NULL,
  message     varchar(1024) NOT NULL DEFAULT '',
  amount      decimal(15,2) NOT NULL,
  created_at  timestamp     NOT NULL DEFAULT current_timestamp(),
  CONSTRAINT  min_campaign_donation CHECK       (amount > 0),
  CONSTRAINT  fk_donation_user      FOREIGN KEY (donatur_id)  REFERENCES user (id)     ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT  fk_donation_campaign  FOREIGN KEY (campaign_id) REFERENCES campaign (id) ON DELETE RESTRICT ON UPDATE RESTRICT
)
;

CREATE OR REPLACE INDEX idx_donation_campaign on campaign_donation(campaign_id);
CREATE OR REPLACE INDEX idx_donation_user on campaign_donation(donatur_id);

-- drop index if exists campaign_impression on campaign_impression; 
CREATE TABLE campaign_impression (
  campaign_id int(11) NOT NULL,
  imp_date    date    NOT NULL DEFAULT current_date(),
  CONSTRAINT  fk_impression_campaign  FOREIGN KEY (campaign_id) REFERENCES campaign (id) ON DELETE CASCADE ON UPDATE CASCADE
)
;

CREATE OR REPLACE INDEX idx_impression_campaign on campaign_impression(campaign_id);

CREATE TABLE campaign_photos (
  campaign_id  int(11)   NOT NULL,
  photo_id     int(11)   NOT NULL,
  created_at   timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (campaign_id, photo_id),
  CONSTRAINT fk_photo    FOREIGN KEY (photo_id)    REFERENCES photo (id)    ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT fk_campaign FOREIGN KEY (campaign_id) REFERENCES campaign (id) ON DELETE CASCADE ON UPDATE RESTRICT
)
;

create or replace view campaign_progress as
with
  donations as (select campaign_id as cid, sum(amount) as total_donation, count(distinct donatur_id) as total_donatur from campaign_donation group by campaign_id),
  impressions as (select campaign_id as cid, count(imp_date) as total_impression from campaign_impression group by campaign_id)
select
  c.id as pid, coalesce(i.total_impression, 0) impressions, coalesce(d.total_donatur, 0) as donatur, coalesce(d.total_donation, 0) as raised, round((coalesce(d.total_donation, 0)/c.target_donasi)*100,2) as raised_pct
from campaign c
left outer join impressions i on i.cid = c.id
left outer join donations d on d.cid = c.id
;

create or replace view campaigns as 
with
  first_photo as (select min(photo_id) as pid, campaign_id as cid from campaign_photos group by campaign_id),
  def_photo as (select fp.cid as cid, p.* from photo p inner join first_photo fp on p.id = fp.pid)
select
  c.*, dp.content_type, dp.photo
from campaign c
left outer join def_photo dp on dp.cid = c.id
;

create or replace view all_campaigns       as select row_number() over (order by id desc) as rid, c.* from campaigns c;

create or replace view active_campaigns    as select row_number() over (order by id desc) as rid, c.* from campaigns c where c.status='ONGOING';

create or replace view rejected_campaigns  as select row_number() over (order by id desc) as rid, c.* from campaigns c where c.status='REJECTED';

create or replace view completed_campaigns as select row_number() over (order by id desc) as rid, c.* from campaigns c where c.status='COMPLETED';

create or replace view reviewed_campaigns  as select row_number() over (order by id desc) as rid, c.* from campaigns c where c.status='PENDING';

create or replace view active_campaigns_progress as
with 
  active as (select c.* from active_campaigns c limit 4)
select
  a.*, p.* from active a inner join campaign_progress p on p.pid = a.id
;

-- create or replace view users as
-- with
--   donatur as (select 'USERS' as role, d.* from donatur),
--   admins as  (select 'ADMIN' as role, a.* from admin)
-- select
--   users.*
-- union
--   admins.*
-- ;

create or replace view user_donation as
with
  donations as (select donatur_id as uid, count(distinct campaign_id) as campaigns, sum(amount) as donated from campaign_donation group by donatur_id),
  users as (select id, email, name, photo, photo_type from user where role='USERS')
select
  u.*, coalesce(d.campaigns, 0) as campaigns, coalesce(d.donated, 0) as donated
from users u
left outer join donations d on d.uid = u.id
;

create or replace view user_donation_by_campaign as select row_number() over (order by campaigns desc, donated desc) as rid, ud.* from user_donation ud;

create or replace view user_donation_by_donation as select row_number() over (order by donated desc, campaigns desc) as rid, ud.* from user_donation ud;

CREATE TABLE campaign_maintainer (
  campaign_id   int(11)   NOT NULL,
  maintainer_id int(11)   NOT NULL,
  created_at    timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (campaign_id, maintainer_id),
  CONSTRAINT  fk_campaign_maintainer FOREIGN KEY (maintainer_id) REFERENCES user (id)     ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT  fk_maintain_campaign   FOREIGN KEY (campaign_id)   REFERENCES campaign (id) ON DELETE CASCADE ON UPDATE RESTRICT
)
;

insert into campaign_maintainer(campaign_id, maintainer_id) values ( 1,3);
insert into campaign_maintainer(campaign_id, maintainer_id) values ( 2,3);
insert into campaign_maintainer(campaign_id, maintainer_id) values ( 3,5);
insert into campaign_maintainer(campaign_id, maintainer_id) values ( 4,4);
insert into campaign_maintainer(campaign_id, maintainer_id) values ( 5,5);
insert into campaign_maintainer(campaign_id, maintainer_id) values ( 6,3);
insert into campaign_maintainer(campaign_id, maintainer_id) values ( 7,3);
insert into campaign_maintainer(campaign_id, maintainer_id) values ( 8,5);
insert into campaign_maintainer(campaign_id, maintainer_id) values ( 9,5);
insert into campaign_maintainer(campaign_id, maintainer_id) values (10,4);
insert into campaign_maintainer(campaign_id, maintainer_id) values (11,5);
insert into campaign_maintainer(campaign_id, maintainer_id) values (12,3);
insert into campaign_maintainer(campaign_id, maintainer_id) values (13,5);
insert into campaign_maintainer(campaign_id, maintainer_id) values (14,4);
insert into campaign_maintainer(campaign_id, maintainer_id) values (15,4);
insert into campaign_maintainer(campaign_id, maintainer_id) values (16,4);


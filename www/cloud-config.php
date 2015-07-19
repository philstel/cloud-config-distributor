<?php
  $public_ipv4 = $_SERVER['REMOTE_ADDR'];
  $private_ipv4 = $_SERVER['REMOTE_ADDR'];
  //hostname is "coreos-" + last octet of ip
  $hostname = "coreos-" . array_slice(explode(".", $private_ipv4), 3, 1)[0];
?>
#cloud-config

coreos:
  etcd2:
    discovery: https://discovery.etcd.io/d762ad526b7089193ddf852d3d69aef4
    advertise-client-urls: http://<?php echo $public_ipv4; ?>:2379
    initial-advertise-peer-urls: http://<?php echo $private_ipv4; ?>:2380
    # listen on both the official ports and the legacy ports
    # legacy ports can be omitted if your application doesn't depend on them
    listen-client-urls: http://0.0.0.0:2379,http://0.0.0.0:4001
    listen-peer-urls: http://<?php echo $private_ipv4; ?>:2380,http://<?php echo $private_ipv4; ?>:7001
  fleet:
    public-ip: <?php echo $public_ipv4; ?>
    metadata: region=mycloud
  update:
    reboot-strategy: etcd-lock
  units:
    - name: etcd2.service
      command: start
    - name: fleet.service
      command: start

hostname: <?php echo $hostname; ?>

users:
  - name: phillu
    coreos-ssh-import-github: philstel
    groups:
      - sudo
      - docker

<?php

declare(strict_types=1);

namespace App\Data\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210322180251 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE subscriber_juridical (id UUID NOT NULL, organization_name VARCHAR(255) NOT NULL, department_name VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, house_number VARCHAR(255) NOT NULL, float_number VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(255) NOT NULL, subscriber_type VARCHAR(10) NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_710297BA6B01BC5B ON subscriber_juridical (phone_number)');
        $this->addSql('COMMENT ON COLUMN subscriber_juridical.id IS \'(DC2Type:subscriber_id)\'');
        $this->addSql('COMMENT ON COLUMN subscriber_juridical.phone_number IS \'(DC2Type:subscriber_phone_number)\'');
        $this->addSql('COMMENT ON COLUMN subscriber_juridical.subscriber_type IS \'(DC2Type:subscriber_type)\'');
        $this->addSql('COMMENT ON COLUMN subscriber_juridical.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE subscriber_private (id UUID NOT NULL, firstname VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, patronymic VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, subscriber_type VARCHAR(10) NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C08F7D566B01BC5B ON subscriber_private (phone_number)');
        $this->addSql('COMMENT ON COLUMN subscriber_private.id IS \'(DC2Type:subscriber_id)\'');
        $this->addSql('COMMENT ON COLUMN subscriber_private.phone_number IS \'(DC2Type:subscriber_phone_number)\'');
        $this->addSql('COMMENT ON COLUMN subscriber_private.subscriber_type IS \'(DC2Type:subscriber_type)\'');
        $this->addSql('COMMENT ON COLUMN subscriber_private.date IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE subscriber_juridical');
        $this->addSql('DROP TABLE subscriber_private');
    }
}

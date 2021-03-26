<?php

declare(strict_types=1);

namespace App\Data\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210326171535 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE phone_dircetory (id UUID NOT NULL, private_subscriber_id UUID DEFAULT NULL, juridical_subscriber_id UUID DEFAULT NULL, phone_number_phone_number VARCHAR(255) NOT NULL, phone_number_subscriber_type VARCHAR(10) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_161F595F46746202 ON phone_dircetory (phone_number_phone_number)');
        $this->addSql('CREATE INDEX IDX_161F595F9650AD29 ON phone_dircetory (private_subscriber_id)');
        $this->addSql('CREATE INDEX IDX_161F595F8ECF84B ON phone_dircetory (juridical_subscriber_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_161F595F467462021EC50039 ON phone_dircetory (phone_number_phone_number, phone_number_subscriber_type)');
        $this->addSql('COMMENT ON COLUMN phone_dircetory.private_subscriber_id IS \'(DC2Type:subscriber_id)\'');
        $this->addSql('COMMENT ON COLUMN phone_dircetory.juridical_subscriber_id IS \'(DC2Type:subscriber_id)\'');
        $this->addSql('CREATE TABLE subscriber_juridical (id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, organization_name VARCHAR(255) NOT NULL, department_name VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, house_number VARCHAR(255) NOT NULL, float_number VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN subscriber_juridical.id IS \'(DC2Type:subscriber_id)\'');
        $this->addSql('COMMENT ON COLUMN subscriber_juridical.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE subscriber_private (id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, firstname VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, patronymic VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN subscriber_private.id IS \'(DC2Type:subscriber_id)\'');
        $this->addSql('COMMENT ON COLUMN subscriber_private.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE phone_dircetory ADD CONSTRAINT FK_161F595F9650AD29 FOREIGN KEY (private_subscriber_id) REFERENCES subscriber_private (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE phone_dircetory ADD CONSTRAINT FK_161F595F8ECF84B FOREIGN KEY (juridical_subscriber_id) REFERENCES subscriber_juridical (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE phone_dircetory DROP CONSTRAINT FK_161F595F8ECF84B');
        $this->addSql('ALTER TABLE phone_dircetory DROP CONSTRAINT FK_161F595F9650AD29');
        $this->addSql('DROP TABLE phone_dircetory');
        $this->addSql('DROP TABLE subscriber_juridical');
        $this->addSql('DROP TABLE subscriber_private');
    }
}

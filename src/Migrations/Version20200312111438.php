<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200312111438 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE criteres DROP FOREIGN KEY FK_E913A5C579F37AE5');
        $this->addSql('DROP INDEX IDX_E913A5C579F37AE5 ON criteres');
        $this->addSql('ALTER TABLE criteres CHANGE id_user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE criteres ADD CONSTRAINT FK_E913A5C5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E913A5C5A76ED395 ON criteres (user_id)');
        $this->addSql('ALTER TABLE diagnostic DROP FOREIGN KEY FK_FA7C888979F37AE5');
        $this->addSql('ALTER TABLE diagnostic DROP FOREIGN KEY FK_FA7C8889BEF955F7');
        $this->addSql('DROP INDEX UNIQ_FA7C8889BEF955F7 ON diagnostic');
        $this->addSql('DROP INDEX IDX_FA7C888979F37AE5 ON diagnostic');
        $this->addSql('ALTER TABLE diagnostic ADD user_id INT NOT NULL, ADD criteres_id INT NOT NULL, DROP id_user_id, DROP id_criteres_id');
        $this->addSql('ALTER TABLE diagnostic ADD CONSTRAINT FK_FA7C8889A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE diagnostic ADD CONSTRAINT FK_FA7C8889A6EB9800 FOREIGN KEY (criteres_id) REFERENCES criteres (id)');
        $this->addSql('CREATE INDEX IDX_FA7C8889A76ED395 ON diagnostic (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FA7C8889A6EB9800 ON diagnostic (criteres_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE criteres DROP FOREIGN KEY FK_E913A5C5A76ED395');
        $this->addSql('DROP INDEX IDX_E913A5C5A76ED395 ON criteres');
        $this->addSql('ALTER TABLE criteres CHANGE user_id id_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE criteres ADD CONSTRAINT FK_E913A5C579F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E913A5C579F37AE5 ON criteres (id_user_id)');
        $this->addSql('ALTER TABLE diagnostic DROP FOREIGN KEY FK_FA7C8889A76ED395');
        $this->addSql('ALTER TABLE diagnostic DROP FOREIGN KEY FK_FA7C8889A6EB9800');
        $this->addSql('DROP INDEX IDX_FA7C8889A76ED395 ON diagnostic');
        $this->addSql('DROP INDEX UNIQ_FA7C8889A6EB9800 ON diagnostic');
        $this->addSql('ALTER TABLE diagnostic ADD id_user_id INT NOT NULL, ADD id_criteres_id INT NOT NULL, DROP user_id, DROP criteres_id');
        $this->addSql('ALTER TABLE diagnostic ADD CONSTRAINT FK_FA7C888979F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE diagnostic ADD CONSTRAINT FK_FA7C8889BEF955F7 FOREIGN KEY (id_criteres_id) REFERENCES criteres (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FA7C8889BEF955F7 ON diagnostic (id_criteres_id)');
        $this->addSql('CREATE INDEX IDX_FA7C888979F37AE5 ON diagnostic (id_user_id)');
    }
}

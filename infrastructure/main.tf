terraform {
  required_providers {
    aws = {
      source  = "hashicorp/aws"
      version = "~> 2.70"
    }
  }
}

provider "aws" {
  profile = "default"
  region  = var.region
}

data "aws_ami" "ubuntu" {
  most_recent = true

  filter {
    name   = "name"
    values = ["ubuntu/images/hvm-ssd/ubuntu-focal-20.04-amd64-server-*"]
  }

  filter {
    name   = "virtualization-type"
    values = ["hvm"]
  }

  owners = ["099720109477"] # Canonical
}

resource "aws_instance" "web" {
  ami             = data.aws_ami.ubuntu.id
  instance_type   = "t2.nano"
  subnet_id       = "subnet-f9d640c4"
  security_groups = ["sg-f02b4289"]
  key_name        = "aaron@cimolini.com general key"

  tags = {
    Name = "Holly Harper Web Production"
  }

  depends_on = [aws_instance.web]
}

resource "aws_eip" "web_ip" {
  vpc      = true
  instance = aws_instance.web.id

  depends_on = [aws_instance.web]
}

resource "aws_key_pair" "key" {
  key_name   = "aaron@cimolini.com general key"
  public_key = "ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAACAQDRjNDmnRZVKkoobOtfqa2NlMERmVUvUHVCdu5uG3BcgmJC5ULdNFyYMGSFOpKUcKoUTGhcAWey3igNu3o/EwBesV0ZAtIzWz3CLe4OyPFVI0dWMGgBsBj0zOdpL5HhvEOZTJ1A+ZtHZuXnV0EN8oSl8tgagcmlE5fV2wZXGJqSnergmXWaWmfXpq05nn5Bu1vh1Fi1wTWuIUMkVFKN47Uh0hCiTOKgdLGA0hedioHzOpAh8/bWZ/SeXvS3x7JDdEpYzjfKQdM/KX31aPLnI/GKz/3jIU7sj7AWTd4es4Q5NFcwMI4Qi4RAuo5IWt1BtmRrvlDpbPHGkgoEaxl+VxwwfsTnR1CDCqnRA4LnFBFoGpK0xnj86oENGy/59q+r8rUQt561dIJkFge8Il5DKGs7HU7KOtRgk2KZUxNyQVttheY3pYqki10xRIMpBGZjh3KcSpdCejgmsaqN2hj49ms+GXFXGQy2gOA+R9dswYt9GTFQbUHXIeEQ19ZneOmvZfnVDZYOXyO/5wGyMLPRP2rwp16cUDYFvNOFlJWUtwh2CdwInmNu5Hfw3CR32dGOX/WU90u9+tD5Iwyiqcd6B7ewJpuQYvdtRBIHcyVfQTW2XAeO3c70YKAGZf9ZjBptGIQu4KqAVTBxeMU8NTN5sAPLGXzvqZ+uy6B1zovC/0OdNw== aaron@cimolini.com"
}

output "ip" {
  value = aws_eip.web_ip.public_ip
}

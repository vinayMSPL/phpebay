USE [EWS]
GO

/****** Object:  Table [dbo].[eBayBuyRequirement]    Script Date: 09/26/2012 23:17:25 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[eBayBuyRequirement](
	[Id] [uniqueidentifier] NOT NULL,
	[LinkedPayPalAccount] [bit] NULL,
	[MaxBuyerPolicyViolationsCount] [int] NULL,
	[MaxBuyerPolicyViolationsPeriod] [int] NULL,
	[MaxItemRequirementsMaxItemCount] [int] NULL,
	[MaxItemRequirementsMinFeedbackScore] [int] NULL,
	[MaxUnpaidItemStrikesInfoCount] [int] NULL,
	[MaxUnpaidItemStrikesInfoPeriod] [int] NULL,
	[MinFeedbackScore] [int] NULL,
	[ShipToRegistrationCountry] [bit] NULL,
	[VerifiedUserRequirementsMinFeedbackScore] [int] NULL,
	[VerifiedUserRequirementsVerifiedUser] [bit] NULL,
	[ZeroFeedbackScore] [bit] NULL,
 CONSTRAINT [PK_eBayBuyRequirement] PRIMARY KEY CLUSTERED 
(
	[Id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

ALTER TABLE [dbo].[eBayBuyRequirement] ADD  CONSTRAINT [DF_eBayBuyRequirement_Id]  DEFAULT (newsequentialid()) FOR [Id]
GO

